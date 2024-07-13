<?php

namespace RefactoringGuru\Prototype\Conceptual;

/**
 * クローン作成機能を持つサンプルクラス
 * 異なる型のフィールドがどのようにクローン作成されるか確認
 */
class Prototype
{
    public $primitive;
    public $component;
    public $circularReference;

    /**
     * PHPではクローン作成のサポートが組み込まれている
     * プリミティブ型(int,stirng, arrayなど)のフィールドであれば、`clone ${対象のオブジェクト}`できる
     * オブジェクトを含むフィールドであれば、クローンされたオブジェクトで参照を保持する
     * そのため、参照されるオブジェクトもクローン作製する必要があります
     */
    public function __clone()
    {
        $this->component = clone $this->component;

        /**
         * ネストされたオブジェクトを持つオブジェクトのクローン作成は特別な処理が必要
         * クローン作成完了後、ネストされたオブジェクトは元のオブジェクトではなく、クローンされたオブジェクトを指す必要があります。
         */
        $this->circularReference = clone $this->circularReference;
        $this->circularReference->prototype = $this;
    }
}

class ComponentWithBackReference
{
    public $prototype;

    /**
     * クローン作成中はコンストラクタは実行されないことに注意してください。
     * コンストラクタ内に複雑なロジックがある場合は、それを `__clone` メソッドでも実行する必要があります。
     */
    public function __construct(Prototype $prototype)
    {
        $this->prototype = $prototype;
    }
}

function clientCode()
{
    $p1 = new Prototype;
    $p1->primitive = 245;

    $p1->component = new \DateTime();
    $p1->circularReference = new ComponentWithBackReference($p1);

    echo "<pre>";

    $p2 = clone $p1;
    if ($p1->primitive === $p2->primitive) {
        // プリミティブ型の値はクローンに引き継がれるのでtrue節
        echo "Primitive field values have been carried over to a clone. Yay!\n";
    } else {
        echo "Primitive field values have not been copied. Booo!\n";
    }

    if ($p1->component === $p2->component) {
        echo "Simple component has not been cloned. Booo!\n";
    } else {
        // コンポーネントはクローンされ,false節
        echo "Simple component has been cloned. Yay!\n";
    }

    if ($p1->circularReference === $p2->circularReference) {
        echo "Component with back reference has not been cloned. Booo!\n";
    } else {
        // 参照付きコンポーネントはクローンされ,false節
        echo "Component with back reference has been cloned. Yay!\n";
    }

    if ($p1->circularReference->prototype === $p2->circularReference->prototype) {
        echo "Component with back reference is linked to original object. Booo!\n";
    } else {
        // 後方参照をもつコンポーネントはクローンにリンクされている,false節
        echo "Component with back reference is linked to the clone. Yay!\n";
    }

    echo "</pre>";

}

clientcode();