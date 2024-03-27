<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Dtos\UserDto;
use App\Enums\AccountStatus;
use App\Enums\Food;
use PDO;

class IndexController
{
    protected $SampleService;

    public function __construct(SampleInterface $SampleService)
    {
        $this->SampleService = $SampleService;
    }


    public function index()
    {
        # feature/#1 メール送受信
        $to = 'mailcatcher@test.com';
        $subject = 'これはmailcatcherのテストです。';
        $message = 'mailcatcherのテスト';
        $additionalHeaders = [
            'From' => 'noreply@test.com'
        ];
        if (!mb_send_mail($to, $subject, $message, $additionalHeaders)) {
        echo 'メールの送信に失敗しました。';
        } else {
        echo 'メールを送信しました';
        }

        # feature/#1 DB疎通
        self::communicationDB();

        // feature/#4 
        $user = self::getUser(1);
        $user = self::decorateUser($user);
        var_dump($user);

        // feature/#5 enums
        $foods = Food::cases();
        $apple = Food::Apple;
        echo $apple->name;
        echo $apple->value;
        var_dump($apple->isVegetable());

        // tryfrom
        $orange = Food::tryFrom('みかん');
        // enumに存在しない値の場合NULLとなる
        $other = Food::tryfrom('ラーメン') ?? Food::Other;
        echo $orange->value;
        echo $other->value;

        // 野菜を取得
        $all = Food::getCases();
        $vege = Food::getVegetables();
        $frui = Food::getFruits();
        var_dump($vege, $frui, $all);
        echo "<hr>";

        $keyValueArray = Food::getKeyValue();
        var_dump($keyValueArray);
        
        echo "<hr>";
        // PureEnum
        $status = AccountStatus::ACTIVE;
        echo $status->name;
        echo $status->text();
        

        var_dump($this->SampleService->index());exit;
    }


    // NOTE: 疎通確認
    private function communicationDB()
    {
        // feature/#1 DB疎通確認

        // $pdo = new PDO($dsn);
        $pdo = new PDO('mysql:host=til_php-db;dbname=til_php', 'til_php', 'til_php-pw');
        $pdo->exec('CREATE TABLE IF NOT EXISTS `users` (id int AUTO_INCREMENT, name varchar(10), INDEX(id));');

        // 結果をカーソルずらしながら、1行ずつ取得
        $stmt = $pdo->query("SELECT * FROM users");
        while ($row = $stmt->fetch()) {
            echo "<pre>"; var_dump($row); echo"</pre>";
        }
        $counts = $pdo->query('SELECT COUNT(*) as cnt FROM users');
        $countResult = $counts->fetch();
        $count = $countResult['cnt'];
        var_dump($count);
        echo "<hr>";

        // 結果を2次元配列で全件取得
        $selectStmt = $pdo->query("SELECT * FROM users");
        $rows = $selectStmt->fetchAll();
        echo "<pre>"; var_dump($rows); echo"</pre>";

        // insert
        $stmt = $pdo->prepare('INSERT INTO users(name) VALUES(:name)');
        $name = "testman{$count}";
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        exit;
    }

    /**
     * DTOでユーザー取得
     * @param int $id
     * @return UserDto | null
     */
    public function getUser(int $id): UserDto | null{
        $pdo = new PDO('mysql:host=til_php-db;dbname=til_php', 'til_php', 'til_php-pw');
        $stmt = $pdo->prepare("SELECT id, name FROM users WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($users) ? new UserDto(...$users) : null;
    }

    /**
     * DTOでユーザー加工
     * @param int $id
     * @return UserDto
     */
    public function decorateUser(UserDto $user)
    {
        $user->isSomething = true;
        return $user;
    }

}