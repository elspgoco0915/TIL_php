<?php
declare(strict_types=1);

// TODO: 型判定
final class DbManager
{
    // TODO: 元に戻す
    // protected $connections = [];
    // protected $repositoryConnectionMap = [];
    // protected $repositories =[];
    public $connections = [];
    public $repositoryConnectionMap = [];
    public $repositories =[];
    

    /**
     * リポジトリごとのコネクション情報を設定
     *
     * @param string $repository_name
     * @param string $name
     */
    public function setRepositoryConnectionMap($repositoryName, $name)
    {
        $this->repositoryConnectionMap[$repositoryName] = $name;
    }

    /**
     * 指定されたリポジトリに対応するコネクションを取得
     *
     * @param string $repository_name
     * @return PDO
     */
    public function getConnectionForRepository($repositoryName)
    {
        // User
        // var_dump($this->repositoryConnectionMap);
        // echo 'tets';
        // exit;
        if (isset($this->repositoryConnectionMap[$repositoryName])) {
            $name = $this->repositoryConnectionMap[$repositoryName];
            $con = $this->getConnection($name);
        } else {
            // var_dump('user');exit;
            $con = $this->getConnection();
            // PDO
            // echo "<pre>";var_dump($con);exit;
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

    /**
     * コネクションを取得
     *
     * @string $name
     * @return PDO
     */
    public function getConnection(string $name = null)
    {
        // var_dump($name);exit;

        if (is_null($name)) {
            // var_dump($this->connections);exit;
            // array<PDO>で'master'を返す
            // Application.phpでdb_manager->connect()してる
            return current($this->connections);
        }
        return $this->connections[$name];
    }

    public function get($repositoryName)
    {
        var_dump($repositoryName);
        // 'User'
        // var_dump($this->repositories);exit;     
        if (!isset($this->repositories[$repositoryName])) {
            // UserRepository
            $repositoryClass = $repositoryName . 'Repository';
            // $repositoryName = 'User' 
            $con = $this->getConnectionForRepository($repositoryName);
            $repository = new $repositoryClass($con);
            $this->repositories[$repositoryName] = $repository;
        }
        // echo "<pre>";var_dump($this->repositories);echo "</pre>";
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