<?php
declare(strict_types=1);

class Application 
{
    protected bool $debug = false;
    protected $request;
    protected $response;
    protected $session;
    // TODO: ローワーキャメルにする
    protected $db_manager;

    /**
     * コンストラクタ
     *
     * @param boolean $debug
     */
    public function __construct($debug = false)
    {
        $this->setDebugMode(true);
        // $this->setDebugMode($debug);
        $this->initialize();
        $this->configure();
    }
    
    /**
     * デバッグモードを設定
     * 
     * @param boolean $debug
     * @return void
     */
    protected function setDebugMode($debug): void
    {
        if ($debug) {
            $this->debug = true;
            ini_set('display_errors', 1);
            error_reporting(-1);
        } else {
            $this->debug = false;
            ini_set('display_errors', 0);
        }
    }

    /**
     * アプリケーションの初期化
     */
    protected function initialize(): void
    {
        // TODO: use文を書いておくべき？？
        
        // $this->request    = new Request();
        // $this->response   = new Response();

        // $this->session    = new Session();
        $this->db_manager = new DbManager();
        // $this->router     = new Router($this->registerRoutes());
    }

    /**
     * アプリケーションの設定
     */
    protected function configure(): void
    {
    }

    /*
        TODO: ルーティング省略
    */

    /**
     * Requestオブジェクトを取得
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Responseオブジェクトを取得
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sessionオブジェクトを取得
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * DbManagerオブジェクトを取得
     *
     * @return DbManager
     */
    public function getDbManager()
    {
        return $this->db_manager;
    }

    public function run()
    {
        echo 'hello, Application!';
        $this->db_manager->connect('master', [
            // TODO: phpdotenvでconstに入れる
            // TODO: charset=utf8はdocker-compose内にあるからいらない？
            // 'dsn'      => 'mysql:dbname=mini_blog;host=localhost;charset=utf8',
            'dsn'      => 'mysql:host=til_php-db;dbname=til_php',
            // 'user'     => 'root',
            // 'password' => 'rootpw',
            'user'     => 'til_php',
            'password' => 'til_php-pw',
        ]);

        $user_repository = $this->db_manager->get('User');
        // $user = new User();
        var_dump($user_repository->getTest());
        // TODO: どれを呼び出しているかわからないのがきもい
        // new Userだったら定義をgetTest()の定義を追える
        /*
        TODO: 理想の実装イメージ
            $user = new User
            $user->getTest();
            UserRepository extends DbRepository
                ->fetch()
            
            new した時点で PDOのインスタンスを作る
            new PDO()
            
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
            
            DIを用いて
            $this->bind($interface, $concrete);
        */
        // user 

        var_dump($this->db_manager->connections);
        var_dump($this->db_manager->repositoryConnectionMap);
        var_dump($this->db_manager->repositories);
        // array(1) { ["master"]=> object(PDO)#4 (0) { } } 
        // array(0) { } 
        // array(1) { ["User"]=> object(UserRepository)#5 (1) { ["con":protected]=> object(PDO)#4 (0) { } } }
        exit;

        // $this->db_manager;
    }
}