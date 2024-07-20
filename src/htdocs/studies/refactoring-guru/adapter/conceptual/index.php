<?php
declare(strict_types=1);

namespace RefactoringGuru\Adapter\Conceptual;

// @url: http://localhost:8080/studies/refactoring-guru/adapter/conceptual/
// @link: https://refactoring.guru/ja/design-patterns/adapter/php/example

/**
 * Targetはクライアントコードで使用されるドメイン固有のインターフェースを定義
 */
class Target
{
    public function request():string
    {
        return "Traget: the default target's behaivior.";
    }
}

/**
* Adaptee には便利な動作が含まれていますが、そのインターフェースは既存のクライアント コードと互換性がありません。
* クライアント コードで Adaptee を使用するには、Adaptee を適応させる必要があります。
*/
class Adaptee
{
    public function specificRequest(): string
    {
        return ".eetpadA eht fo roivaheb laicepS";
    }
}

/**
　* アダプタは、アダプタ先のインターフェースをターゲットのインターフェースと互換性のあるものにします。
 */
class Adapter extends Target
{
    private $adaptee;

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function request():string 
    {
        return "Adapter: (TRANSLATED) " . strrev($this->adaptee->specificRequest());
    }
}

/**
 * クライアントコードはTartgetインターフェイスに従うすべてのクラスをサポートします。
 */
function clientCode(Target $target)
{
    echo $target->request();
}


echo "<pre>";

echo "Client: I can work just fine with the Target objects:\n";
$target = new Target();
clientCode($target);
echo "\n\n";

$adaptee = new Adaptee();
echo "Client: The Adaptee class has a weird interface. See, I don't understand it:\n";
echo "Adaptee: " . $adaptee->specificRequest();
echo "\n\n";

echo "Client: But I can work with it via the Adapter:\n";
$adapter = new Adapter($adaptee);
clientCode($adapter);

echo "</pre>";

