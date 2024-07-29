<?php

namespace RefactoringGuru\Facade\Conceptual;

/**
 * Facadeクラスは複数のサブシステムの複雑なロジックへのシンプルなインターフェースを提供する
 * Facadeはクライアントの要求をサブシステム内の適切なオブジェクトに委任する
 * Facadeはオブジェクトのライフサイクルの管理も担当する
 * これらすべてにより、クライアントはサブシステムの複雑さを考慮する必要がありません
 */
class Facade
{
    protected $subsystem1;
    protected $subsystem2;

    /**
     * アプリケーションのニーズに応じて、既存のサブシステムを提供したり
     * Facadeに独自に作成させたりできます
     */
    public function __construct(
        $subsystem1 = null,
        $subsystem2 = null
    ) {
        $this->subsystem1 = $subsystem1 ?: new Subsystem1();
        $this->subsystem2 = $subsystem2 ?: new Subsystem2();
    }

    /**
     * Facadeのメソッドはサブシステムの高度な機能への便利なショートカットです
     * ただし、クライアントはサブシステムの機能のほんの一部しか利用できません
     */
    public function operation(): string
    {
        $result = "Facade initializes subsystems:\n";
        $result .= $this->subsystem1->operation1();
        $result .= $this->subsystem2->operation1();
        $result .= "Facade orders subsystems to perform the action:\n";
        $result .= $this->subsystem1->operationN();
        $result .= $this->subsystem2->operationZ();

        return $result;
    }
}

/**
 * サブシステムは、Facadeまたはクライアントから直接リクエストを受け入れることができます。
 * いずれにせよ、サブシステムにとっては、Facadeも別のクライアントであり、サブシステムの一部ではないです
 */
class Subsystem1
{
    public function operation1(): string
    {
        return "Subsystem1: Ready!\n";
    }

    // ...

    public function operationN(): string
    {
        return "Subsystem1: Go!\n";
    }
}

/**
 * 一部のFacadeは複数のサブシステムと同時に動作できます
 */
class Subsystem2
{
    public function operation1(): string
    {
        return "Subsystem2: Get ready!\n";
    }

    // ...

    public function operationZ(): string
    {
        return "Subsystem2: Fire!\n";
    }
}

/**
 * クライアントコードでは、Facadeによって提供されるインターフェースを介して、サブシステムを操作する
 * Facadeがサブシステムのライフサイクルを管理する場合、クライアントはサブシステムの存在さえ知らない可能性があります。
 */
function clientCode(Facade $facade)
{
    // ...

    echo $facade->operation();

    // ...
}

/**
 * クライアントコードには、サブシステムのオブジェクトの一部がすでに作成されている場合があります
 * この場合、Facadeに新しいインスタンスを作成させるのではなく、これらのオブジェクトを使用してFacadeを初期化するほうが良い場合があります
 */
echo "<pre>";
$subsystem1 = new Subsystem1();
$subsystem2 = new Subsystem2();
$facade = new Facade($subsystem1, $subsystem2);
clientCode($facade);
echo "</pre>";
