<?php
declare(strict_types=1);

// TODO: 型判定
class DbManager
{
    protected $connections = [];
    protected $repositoryConnectionMap = [];
    protected $repositories =[];

    public function setRepositoryConnectionMap($repositoryName, $name)
    {
        $this->repositoryConnectionMap[$repositoryName] = $name;
    }

    public function getConnectionForRepository($repositoryName)
    {
        if (isset($this->repositoryConnectionMap[$repositoryName])) {
            $name = $this->repositoryConnectionMap[$repositoryName];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }
        return $con;
    }

    public function connect($name, $params)
    {
        // TODO: feature/#4_type_hints_arrayを活かす
        $params = array_merge([
            'dsn'       => null,
            'user'      => '',
            'password'  => '',
            'options'   => [],
        ], $params);
        $con = new PDO(
            $params['dsn'], 
            $params['user'], 
            $params['password'], 
            $params['options'], 
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connections[$name] = $con;
    }

    public function getConnection($name = null)
    {
        if (is_null($name)) {
            return current($this->connections);
        }
        return $this->connections[$name];
    }

    public function get($repositoryName)
    {
        if (!isset($this->repositories[$repositoryName])) {
            $repositoryClass = $repositoryName . 'Repository';
            $con = $this->getConnectionForRepository($repositoryName);
            $repository = new $repositoryClass($con);
            $this->repositories[$repositoryName] = $repository;
        }
        return $this->repositories[$repositoryName];
    }

    // 接続の解放処理
    public function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $con) {
            unset($con);
        }
    }


}