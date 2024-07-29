<?php
declare(strict_types=1);

namespace RefactoringGuru\State\RealWorld;

/**
 * refactoring.guru.realworldがないため、ritolabから拝借
 * @url https://www.ritolab.com/posts/140
 */
trait Singleton
{
    static $instance = null;

    // NOTE: trait使用元のclassでコンストラクタをオーバライドして使用する
    final protected function __construct(){}

    final public static function getInstance()
    {
        return static::$instance ?? static::$instance = new static();
    }

    /**
     * @throws \Exception
    */
    final public function __clone()
    {
        throw new \Exception("This instance is not clone because singleton class.");
    }

    /**
     * @throws \Exception
    */
    public final function __wakeup()
    {
        throw new \Exception('This instance is not unserialize because singleton class');
    }
}

interface StateInterface
{
    public function nextState();
    public function getStatus();
}

class OnlineState implements StateInterface
{
    use Singleton;

    public function nextState()
    {
        return OfflineState::getInstance();
    }

    public function getStatus()
    {
        return '<span style="color: blue;">オンライン</span>';
    }
}


class OfflineState implements StateInterface
{
    use Singleton;

    public function nextState()
    {
        return OnlineState::getInstance();
    }

    public function getStatus()
    {
        return '<span style="color: darkgray;">オフライン</span>';
    }
}


class User
{
    private $name;
    private $state;

    public function __construct($name)
    {
        $this->name = $name;
        $this->state = OnlineState::getInstance();
    }

    public function getName()
    {
        return $this->name;
    }

    public function changeState()
    {
        $this->state = $this->state->nextState();
    }

    public function getStatus()
    {
        return $this->state->getStatus();
    }
}

/**
 * The client code.
 */
$user = new User('test');

echo sprintf('ユーザ：%s 　状態：%s<br><br>', $user->getName(), $user->getStatus());

// 状態を変更する
$user->changeState();
echo sprintf('ユーザ：%s 　状態：%s<br><br>', $user->getName(), $user->getStatus());

// 状態を変更する
$user->changeState();
echo sprintf('ユーザ：%s 　状態：%s<br><br>', $user->getName(), $user->getStatus());

// 状態を変更する
$user->changeState();
echo sprintf('ユーザ：%s 　状態：%s<br><br>', $user->getName(), $user->getStatus());