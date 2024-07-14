<?php

namespace RefactoringGuru\Command\Conceptual;

/**
 * Commandインタフェースは、コマンドを実行するためのメソッドを宣言する
 */
interface Command
{
    public function execute(): void;
}

/**
 * 各コマンドは、単独でシンプルな操作を実装します
 */
class SimpleCommand implements Command
{
    private $payload;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    public function execute(): void
    {
        echo "SimpleCommand: See, I can do simple things like printing (" . $this->payload . ")<br>";
    }
}

/**
 * ただし、一部のコマンドではより複雑な操作を「Receiver」と呼ばれる他のオブジェクトに委任します
 */
class ComplexCommand implements Command
{
    /**
     * @var Receiver
     */
    private $receiver;

    /**
     * receiverのメソッドを起動するために必要なコンテキストデータ
     */
    private $a;
    private $b;

    /**
     * 複雑なコマンドでは、コンストラクタを介して、1つまたは複数のReceiverオブジェクトと任意のデータを受け入れます
     */
    public function __construct(Receiver $receiver, string $a, string $b)
    {
        $this->receiver = $receiver;
        $this->a = $a;
        $this->b = $b;
    }

    /**
     * コマンドはReceiverの任意のメソッドを委任できる
     */
    public function execute(): void
    {
        // 複雑な処理は受信オブジェクトで実行する必要がある
        echo "ComplexCommand: Complex stuff should be done by a receiver object.<br>";
        $this->receiver->doSomething($this->a);
        $this->receiver->doSomethingElse($this->b);
    }
}

/**
 * Receiverクラスには重要なビジネスロジックを含む
 * リクエストの実行に関連するあらゆる種類の操作を実行する方法を知っている
 * 実際、どのクラスもReceiverとして機能する
 */
class Receiver
{
    public function doSomething(string $a): void
    {
        echo "Receiver: Working on (" . $a . ".)<br>";
    }

    public function doSomethingElse(string $b): void
    {
        echo "Receiver: Also working on (" . $b . ".)<br>";
    }
}

/**
 * Invokerは１つまたは複数のコマンドに関連付けられ、コマンドにリクエストを送信する
 */
class Invoker
{
    private $onStart;
    private $onFinish;

    public function setOnStart(Command $command): void
    {
        $this->onStart = $command;
    }

    public function setOnFinish(Command $command): void
    {
        $this->onFinish = $command;
    }

    /**
     * Invokerは具象CommandクラスやReceiverクラスに依存しない
     * Invokerはコマンドを実行することで、リクエストを間接的にレシーバーに渡します
     */
    public function doSomethingImportant(): void
    {
        echo "Invoker: Does anybody want something done before I begin?<br>";
        if ($this->onStart instanceof Command) {
            $this->onStart->execute();
        }

        echo "Invoker: ...doing something really important...<br>";

        echo "Invoker: Does anybody want something done after I finish?<br>";
        if ($this->onFinish instanceof Command) {
            $this->onFinish->execute();
        }
    }
}

/**
 * クライアントコード
 * 任意のコマンドを使用して呼び出し元をパラメーター化できる
 */
$invoker = new Invoker();
$invoker->setOnStart(new SimpleCommand("Say Hi!"));
$receiver = new Receiver();
$invoker->setOnFinish(new ComplexCommand($receiver, "send email", "save report"));

$invoker->doSomethingImportant();