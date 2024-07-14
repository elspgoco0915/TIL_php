<?php
declare(strict_types=1);

namespace RefactoringGuru\Command\RealWorld;

/**
 * Commandインターフェースは主となる実行メソッドとコマンド、メタデータを取得するためのヘルパーメソッドを宣言します
 */
interface Command
{
    public function execute(): void;
    public function getId(): int;
    public function getStatus(): int;
}

/**
 * 基本webスクレイピングのコマンドは、すべて具象Webスクレイピングコマンドに共通するメソッドを定義します
 */
abstract class WebScrapingCommand implements Command
{
    public $id;
    public $status = 0;

    /**
     * スクレイピングするURL
     * @var string
     */
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * すべてのwebスクレイピングコマンドの実行メソッドは似ているため
     * デフォルトの実装は提供して、必要に応じてサブクラスでオーバーライドできるようにします
     */
    public function execute(): void
    {
        $html = $this->download();
        $this->parse($html);
        $this->complete();
    } 

    public function download(): string
    {
        $html = file_get_contents($this->getURL());
        echo "WebScrapingCommand: Downloaded {$this->url}\n";
        return $html;
    }

    abstract public function parse(string $html): void;

    public function complete(): void
    {
        $this->status = 1;
        Queue::get()->completeCommand($this);
    }

}

/**
 * 映画のジャンルを取得する具象コマンド
 */
class IMDBGenresScrapingCommand extends WebScrapingCommand
{
    public function __construct()
    {
        $this->url = "https://www.imdb.com/feature/genre/";
    }

    public function parse($html): void
    {
        $pattern = "|href=\"(https://www.imdb.com/search/title\?genres=.*?)\"&explore=title_type%2Cgenres&ref_=ft_popular_0|";

        preg_match_all($pattern, $html, $matches);

        // NOTE: 取得できた体
        $matches[1] = [
            "https://m.imdb.com/search/title/?genres=action",
        ];

        echo "IMDBGenresScrapingCommand: Discovered " . count($matches[1]) . " genres.\n";

        foreach ($matches[1] as $genre) {
            Queue::get()->add(new IMDBGenrePageScrapingCommand($genre));
        }
    }
}

/**
 * 映画のジャンルのページを取得する具象コマンド
 */
class IMDBGenrePageScrapingCommand extends WebScrapingCommand
{
    private $page;

    public function __construct(string $url, int $page = 1)
    {
        parent::__construct($url);
        $this->page = $page;
    }

    public function getURL(): string
    {
        return $this->url . '?page=' . $this->page;
    }

    public function parse(string $html): void
    {
        preg_match_all("|href=\"(/title/.*?/)\?ref_=sr_t_1\"|", $html, $matches);
        echo "IMDBGenrePageScrapingCommand: Discovered " . count($matches[1]) . " movies.\n";

        // NOTE: とれた体
        $matches[1] = ["/title/tt9335498/?ref_=sr_t_8"];

        foreach ($matches[1] as $moviePath) {
            $url = "https://www.imdb.com" . $moviePath;
            Queue::get()->add(new IMDBMovieScrapingCommand($url));
        }

        // Parse the next page URL.
        if (preg_match("|Next &#187;</a>|", $html)) {
            Queue::get()->add(new IMDBGenrePageScrapingCommand($this->url, $this->page + 1));
        }
    }
}

/**
 * 映画の情報をスクレイピングする具象コマンド
 */
class IMDBMovieScrapingCommand extends WebScrapingCommand
{
    /**
     * Get the movie info from a page like this:
     * https://www.imdb.com/title/tt4154756/
     */
    public function parse(string $html): void
    {
        // $oldPattern = "|<h1 itemprop=\"name\" class=\"\">(.*?)</h1>|";
        $pattern = "|<span class=\"hero__primary-text\" data-testid=\"hero__primary-text\">(.*?)</span>|";

        if (preg_match($pattern, $html, $matches)) {
            $title = $matches[1];
        }
        // NOTE: ここは取得できたので大丈夫
        // $matches[1] = "鬼滅の刃";
        echo "IMDBMovieScrapingCommand: Parsed movie $title.\n";
    }
}


/**
 * QueueクラスはInvokerとして機能させる
 * コマンドオブジェクトをスタックして、一つずつ実行する
 * スクリプトの実行が突然終了した場合、キューとすべてのコマンドは簡単に復元できるため、実行したすべてのコマンドを繰り返す必要がない
 */
class Queue 
{
    private $db;

    public function __construct()
    {
        $this->db = new \SQLite3(__DIR__ . '/commands.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $this->db->query('CREATE TABLE IF NOT EXISTS "commands" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "command" TEXT, "status" INTEGER)');
    }

    public function isEmpty(): bool
    {
        $query = 'SELECT COUNT("id") FROM "commands" WHERE status = 0';
        return $this->db->querySingle($query) === 0;
    }

    public function add(Command $command):void
    {
        $query = 'INSERT INTO commands (command, status) VALUES (:command, :status)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':command', base64_encode(serialize($command)));
        $statement->bindValue(':status', $command->getStatus());
        $statement->execute();
    }

    public function getCommand(): Command
    {
        $query = 'SELECT * FROM "commands" WHERE "status" = 0 LIMIT 1';
        $record = $this->db->querySingle($query, true);
        $command = unserialize(base64_decode($record["command"]));
        $command->id = $record['id'];

        return $command;
    }

    public function completeCommand(Command $command): void
    {
        $query = 'UPDATE commands SET status = :status WHERE id = :id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':status', $command->getStatus());
        $statement->bindValue(':id', $command->getId());
        $statement->execute();
    }

    public function work(): void
    {
        while (!$this->isEmpty()) {
            $command = $this->getCommand();
            $command->execute();
        }
    }

    /**
     * 便宜上、シングルトンパターンを使っています
     */
    public static function get(): Queue
    {
        static $instance;
        if (!$instance) {
            $instance = new Queue();
        }

        return $instance;
    }
}


/**
 * クライアントコード
 */
$queue = Queue::get();

if ($queue->isEmpty()) {
    $queue->add(new IMDBGenresScrapingCommand());
}

$queue->work();