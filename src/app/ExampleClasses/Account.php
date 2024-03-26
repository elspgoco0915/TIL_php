<?php
declare(strict_types=1);

namespace App\ExampleClasses;

use App\Enums\AccountStatus;

class Account
{
    /**
     * コンストラクタでのプロパティのプロモーション
     */
    public function __construct(
        private AccountStatus $accountStatus
    ) 
    {
    }

    /**
     * ステータス変更
     * @param AccountStatus $changedStatus
     */
    public function changeTo(AccountStatus $changedStatus)
    {
        $this->accountStatus = $changedStatus;
    }

    /**
     * ステータス確認
     * @return AccountStatus
     */
    public function getStatus(): AccountStatus
    {
        return $this->accountStatus;
    } 
}