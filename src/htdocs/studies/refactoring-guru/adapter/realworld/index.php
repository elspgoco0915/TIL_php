<?php

namespace RefactoringGuru\Adapter\RealWorld;

/**
 * Adapter パターンでは、 自分のコードの大部分と互換性がない他社作成のクラスや旧来のクラスを使えるようにします。
 * たとえば、 Slack,Facebook,SMS（その他適宜） などの他社のサービスをサポートするために自分のアプリの通知インターフェースを書き直す代わりに
 * アプリからの呼び出しを、 それぞれの他社作成クラスが要求するインターフェースとデータ形式に適合させる特別なラッパーを書くことができます。
 */

/**
 * Targetインターフェースは、アプリケーションのクラスが既に従っているインターフェースを表します。
 */
interface Notification
{
    public function send(string $title, string $message);
}

/**
 * Targetインタフェースに従う既存クラスの例
 * 実際は、多くのアプリでは、このようなインターフェースが明確に定義されていない可能性があります。
 * そのような状況の場合の最善策は、アプリケーションの既存のクラスの１つから、Adapterを拡張することです。
 * それが面倒な場合 (たとえば、SlackNotification が EmailNotification のサブクラスのように感じられない場合)、インターフェースを抽出することが最初のステップになります。
 */
class EmailNotification implements Notification
{
    private $adminEmail;

    public function __construct(string $adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function send(string $title, string $message):void
    {
        mail($this->adminEmail, $title, $message);
    }
}

/**
 * AdapteeはTargetインターフェースと互換性のない便利なクラス
 * コードはサードパーティのライブラリによって提供される可能性があるため、
 * クラスのコードをTargetインターフェースに合わせて変更することはできません
 */
class SlackApi
{
    private $login;
    private $apiKey;

    public function __construct(string $login, string $apiKey)
    {
        $this->login = $login;
        $this->apiKey = $apiKey;
    }

    public function logIn(): void
    {
        // Send authentication request to Slack web service.
        echo "Logged in to a slack account '{$this->login}'.\n";
    }

    public function sendMessage(string $chatId, string $message): void
    {
        // Send message post request to Slack web service.
        echo "Posted following message into the '$chatId' chat: '$message'.\n";
    }
}

/**
 * AdapterはTargetインターフェースとAdapteeクラスをつなげるクラス
 * この場合は、アプリケーションはSlack APIを使用して通知を送信できる
 */
class SlackNotification implements Notification
{
    private $slack;
    private $chatId;

    public function __construct(SlackApi $slack, string $chatId)
    {
        $this->slack = $slack;
        $this->chatId = $chatId;
    }

    /**
     * Adapterはインターフェースを適応できるだけでなく
     * 受信データをアダプタ対象に必要な形式に変換することもできます
     */
    public function send(string $title, string $message): void
    {
        $slackMessage = "#" . $title . "# " . strip_tags($message);
        $this->slack->logIn();
        $this->slack->sendMessage($this->chatId, $slackMessage);
    }
}

/**
 * クライアントコードはTargetインターフェースに従う任意のクラスで動作します
 */
function clientCode(Notification $notification)
{
    // ...

    echo $notification->send("Website is down!",
        "<strong style='color:red;font-size: 50px;'>Alert!</strong> " .
        "Our website is not responding. Call admins and bring it up!");

    // ...
}

echo "<pre>";

echo "Client code is designed correctly and works with email notifications:\n";
$notification = new EmailNotification("developers@example.com");
clientCode($notification);
echo "\n\n";

echo "The same client code can work with other classes via adapter:\n";
$slackApi = new SlackApi("example.com", "XXXXXXXX");
$notification = new SlackNotification($slackApi, "Example.com Developers");
clientCode($notification);

echo "</pre>";
