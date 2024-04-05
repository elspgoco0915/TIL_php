<?php
declare(strict_types=1);

// TODO: 型判定
class DbRepository
{
    protected $con; // PDO

    public function __construct($con)
    {
        $this->setConnection($con);
    }

    public function setConnection($con)
    {
        $this->con = $con;
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetch($sql, $params = [])
    {
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 結果セットから、全ての行を取得する
     * 
     * @param string $sql 
     * @param array $params
     * @return array
     */
    public function fetchAll($sql, $params = [])
    {
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}