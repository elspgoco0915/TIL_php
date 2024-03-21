<?php
declare(strict_types=1);

namespace tests\unit;

use PHPUnit\Framework\TestCase;
use App\ExampleClasses\Account;
use App\Enums\AccountStatus;

/**
 * Account Test
 * @package tests\unit
 */
class AccountTest extends TestCase {

    /**
     * @test
     */
    public function ステータス初期状態確認()
    {
        $account = new Account(AccountStatus::ACTIVE);
        $this->assertSame($account->getStatus(), AccountStatus::ACTIVE);
    }

    /**
     * @test
     */
    public function ステータスが変更できる()
    {
        $account = new Account(AccountStatus::INACTIVE);
        $account->changeTo(AccountStatus::SUSPENDED);
        $this->assertSame($account->getStatus(), AccountStatus::SUSPENDED);
    }

}