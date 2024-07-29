<?php
declare(strict_types=1);

namespace RefactoringGuru\State\RealWorld;

/*
 * Context は、クライアントにとって重要なインターフェースを定義します。
 * また、Context の現在の状態を表す State サブクラスのインスタンスへの参照も保持します。
*/
class Context 
{
    /**
     * @var State Contextの現在の状態の参照
     */
    private $state;

    public function __construct(State $state)
    {
        $this->transitionTo($state);
    }

    /**
     * Contextにより、実行時にStateオブジェクトを変更します
     */
    public function transitionTo(State $state)
    {
        echo "Context: transition to". get_class($state).".\n";
        $this->state = $state;
        $this->state->setContext($this);
    }

    /**
     * Context内の一部メソッドでは、現在のStateオブジェクトに委譲します
     */
    public function request1(): void
    {
        $this->state->handle1();
    }

    public function request2(): void
    {
        $this->state->handle2();
    }
}

/**
 * 基本Stateクラスはすべての具象Stateが実装する必要があるメソッドを宣言
 * State に関連付けられた Context オブジェクトへの後方参照も提供します
 * この後方参照は、State が Context を別の State に遷移するために使用できます
 */
abstract class State
{
    protected $context;

    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    abstract public function handle1(): void;
    abstract public function handle2(): void;

}

/**
 * 具象的Stateは、Context状態に関連付けられた様々な動作の実装をします
 */
class ConcreteStateA extends State
{
    public function handle1(): void
    {
        echo "ConcreteStateA handles request1.\n";
        echo "ConcreteStateA wants to change the state of the context.\n";
        $this->context->transitionTo(new ConcreteStateB());
    }

    public function handle2(): void
    {
        echo "ConcreteStateA handles request2.\n";
    }
}


class ConcreteStateB extends State
{
    public function handle1(): void
    {
        echo "ConcreteStateB handles request1.\n";
    }

    public function handle2(): void
    {
        echo "ConcreteStateB handles request2.\n";
        echo "ConcreteStateB wants to change the state of the context.\n";
        $this->context->transitionTo(new ConcreteStateA());
    }
}

/**
 * The client code.
 */
echo "<pre>";
$context = new Context(new ConcreteStateA());
$context->request1();
$context->request2();

echo "</pre>";
