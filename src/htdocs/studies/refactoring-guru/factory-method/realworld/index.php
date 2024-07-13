<?php
declare(strict_types=1);

namespace RefactoringGuru\FactoryMethod\RealWorld;

/**
 * Factory Method パターンを使い、 ソーシャル・ネットワークのコネクターを作成するためのインターフェースが宣言されています。 
 * クライアント・コードを特定のソーシャル・ネットワーク用の特別なクラスに結合することなく、 ネットワークへのログイン、 投稿の作成、 その他の作業を行えます。
 * @see https://refactoring.guru/ja/design-patterns/factory-method/php/example#example-1
 */


/**
 * ソーシャルネットワーク送信機 (Creatorクラス)
 * Productを直接コンストラクタせず、ファクトリーメソッド(getSocialNetwork)を宣言する
 * そのため、SocialNetworkPosterのサブクラスによって、作成するプロダクトを変更できる
 */
abstract class SocialNetworkPoster
{
    /**
     * ファクトリメソッド
     * 返り値の型を抽象コネクタ(SocialNetWorkConnector)にすることで、サブクラスは具象コネクタ(FacebookConnector, LinkedInConnector)をメソッド内で返すことができる
     * @return SocialNetWorkConnector
     */
    abstract public function getSocialNetwork(): SocialNetWorkConnector;

    /**
     * コアのビジネスロジック
     * サブクラスに継承する
     * @return void
     */
    public function post($content): void
    {
        $network = $this->getSocialNetwork();
        $network->login();
        $network->createPost($content);
        $network->logout();
    }
}

/**
 * Facebook用
 * 具象Creatorはクライアントが実際に使用するクラス
 * 親のSocialNetworkPosterのpostを継承してるので注意
 */
class FacebookPoster extends SocialNetworkPoster
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new FacebookConnector($this->login, $this->password);
    }
}

/**
 * LinkedIn用
 * 具象Creatorはクライアントが実際に使用するクラス
 * 親のSocialNetworkPosterのpostを継承してるので注意
 */
class LinkedInPoster extends SocialNetworkPoster
{
    private $email, $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new LinkedInConnector($this->email, $this->password);
    }
}

/**
 * プロダクトインターフェースは、各プロダクトが実装すべきメソッドを宣言する
 */
interface SocialNetworkConnector
{
    public function login(): void;
    public function logout(): void;
    public function createPost($content): void;
}

/**
 * 具象プロダクトでFacebook APIを実装
 * loginId, passwordでログインしてる
 */
class FacebookConnector implements SocialNetworkConnector
{
    private $loginId, $password;

    public function __construct(string $loginId, string $password)
    {
        $this->loginId = $loginId;
        $this->password = $password;
    }

    public function login(): void
    {
        echo "Send HTTP API request to log in user {$this->loginId} with "."password {$this->password}<br>";
    }

    public function logout(): void
    {
        echo "Send HTTP API request to log out user {$this->loginId}<br>";
    }

    public function createPost($content): void
    {
        echo "Send HTTP API requests to create a post in Facebook timeline.<br> SendContent:".$content."<br>";
    }

}

/**
 * 具象プロダクトでLinkedIn APIを実装
 * email, passwordでログインしてる
 */
class LinkedInConnector implements SocialNetworkConnector
{
    private $email, $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function login(): void
    {
        echo "Send HTTP API request to log in user {$this->email} with "."password $this->password<br>";
    }

    public function logout(): void
    {
        echo "Send HTTP API request to log out user {$this->email}<br>";
    }

    public function createPost($content): void
    {
        echo "Send HTTP API requests to create a post in LinkedIn timeline.<br> SendContent:".$content."<br>";
    }
}

/**
 * クライアントコード
 * 具体的なクラスに依存しないため、SocialNetworkPosterの任意のサブクラス(FacebookConnector, LinkedInConnector)で動作する
 */
function clientCode(SocialNetworkPoster $creator)
{
    // ...
    $creator->post("Hello world!");
    $creator->post("I had a large hamburger this morning!");
    // ...
}

/**
 * アプリはどのソーシャルネットワークと連携するかをサブクラスのオブジェクトを作成して渡すことができる
 */
echo "testing concrete creator1:<br>";
clientCode(new FacebookPoster("john_smith", "*****"));
echo "<hr>";

echo "testing concrete creator2:<br>";
clientcode(new LinkedInPoster("test@mail.com", "*****"));