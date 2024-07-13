<?php
declare(strict_types=1);

namespace RefactoringGuru\FactoryMethod\Conceptual;

/**
 * Creatorクラス
 * Productクラスのオブジェクトを返すファクトリメソッドを宣言する
 * 通常、Creatorのサブクラスはこのメソッドの実装をする
 */
abstract class Creator
{
    /**
     * Creatorはファクトリメソッドのデフォルトを実装する場合もある（今回はabstract）
     */
    abstract public function factoryMethod(): Product;

    /**
     * creatorはプロダクトを作成する（=ファクトリメソッド）だけではないことに注意する
     * ファクトリメソッドによって返されたProductオブジェクトに依存するコアのビジネスロジックが含まれる
     * creatorのサブクラスはファクトリメソッドをオーバーライドして、異なるプロダクトを返すことで、ビジネスロジックを間接に変更できる
     */
    public function someOperation(): string
    {
        $product = $this->factoryMethod();
        $result = "Creator: The same creator's code has just worked with " . $product->operation();
        return $result;
    }
}

/**
 * 具象Creatorは、返すプロダクトを変更するために、親のファクトリメソッドを上書きする
 */
class ConcreteCreator1 extends Creator
{
    /**
     * 戻り値は具象(ConcretProduct1)だが、型は抽象(Product)にする
     * そうすることで、Creatorは具象なプロダクトに依存せず、独立することができる
     * @return Product
     */
    public function factoryMethod(): Product
    {
        return new ConcreteProduct1();
    }
}

/**
 * Productインタフェースは、全ての具象プロダクトが実装すべきメソッドを宣言してる
 */
interface Product
{
    public function operation(): string;
}

/**
 * 具象プロダクトでは、インタフェースのメソッドを実装する
 */
class ConcreteProduct1 implements Product
{
    public function operation(): string
    {
        return "{result of the concrete product1}";
    }
}

class ConcreteProduct2 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct2}";
    }
}

/**
 * クライアントコード
 * 具象なCreatorクラスのインスタンスで動かす
 */
function clientCode(Creator $creator)
{
    // ...
    echo "Client: I'm not aware of the creator's class, but it still works.<br>"
        . $creator->someOperation();
    // ...
}

echo "App: Launched with the ConcreteCreator1.<br>";
clientCode(new ConcreteCreator1());
echo "<br><br>";

