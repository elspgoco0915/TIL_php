<?php
declare(strict_types=1);

// TODO: 独自の疎通テストなので、後ほど書きかえる
class UserRepository extends DbRepository
{
    /**
     * 疎通テスト
     * @return array
     */
    public function getTest()
    {
        $sql = "SELECT id, name FROM users";
        return $this->fetchAll($sql);
    }

}