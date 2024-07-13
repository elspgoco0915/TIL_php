<?php

namespace RefactoringGuru\Prototype\RealWorld;

/**
 * Prototype パターンは、すべてのフィールドを直接コピーしてオブジェクトを再構築する代わりに、既存のオブジェクトを複製する便利な方法です。
 * 直接的な方法では、クローンされるオブジェクトのクラスに密に結合してしまうばかりか 非公開フィールドの内容はコピーできないという問題があります。 
 * Prototype では 実際のクローンの作業は、クローンされるクラス中で行われるため、非公開フィールドへのアクセスは無制限です。
 * この例では、複雑な Page オブジェクトのクローン作成に Prototype パターンを使用しています。 
 * Page クラスには多数の非公開フィールドがありますが、 Prototype パターンのおかげで、 クローンされたオブジェクトにうまく引き継がれます。
 */

/**
 * プロトタイプ
 */
class Page
{
    private string $title;
    private string $body;

    /**
     * @var Author
     */
    private Author $author;
    private array $comments = [];

    /**
     * @var \DateTime
     */
    private \DateTime $date;

    // そのほか100のprivateがあるとする

    /**
     * コンストラクタ
     * cloneされた際は__construct→__cloneの順番で呼ばれる
     */
    public function __construct(string $title, string $body, Author $author)
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->author->addToPage($this);
        $this->date = new \DateTime();
    }

    public function addComment(string $comment): void
    {
        $this->comments[] = $comment;
    }

    /**
     * クローンされたオブジェクトに引き継ぐデータを制御する
     * 
     * Pageクラスがクローンされると次のようになります
     * 新しい「...のコピー」とタイトルがつきます
     * ページの作成者は変わりません
     * そのため、クローンされたページを作成者のページのリストに追加する際に、既存のオブジェクト参照はそのままにします
     * 古いページのコメントは引き継がれないので、空値にします。
     * 新しい日付にします
     */
    public function __clone()
    {
        $this->title = $this->title."のコピー";
        $this->author->addToPage($this);
        $this->date = new \DateTime();
        $this->comments = [];        
    }
}

class Author
{
    private string $name;

    /**
     * @var Page[]
     */
    private array $pages = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addToPage(Page $page): void
    {
        $this->pages[] = $page;
    }
}

/**
 * クライアントコード
 */
function clientCode()
{
    $author = new Author("john smith");
    $page = new Page("tip of the day", "keep calm and carry on.", $author);

    // ...

    $page->addComment("nice tip, thanks");

    // ...

    $draft = clone $page;
    echo "<pre>";
    // クローンのダンプをしてみます、作成者が２つのオブジェクトを参照していることを確認できます
    echo "Dump of the clone. Note that the author is now referencing two objects.\n\n";
    print_r($draft);
    echo "</pre>";

}

clientCode();