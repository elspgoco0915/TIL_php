<?php
declare(strict_types=1);

abstract class Application 
{
    protected bool $debug = false;
    protected $request;
    protected $response;
    protected $session;
    protected Router $router;
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
     * デバッグモードの確認
     */
    public function isDebugMode(): bool
    {
        return $this->debug;
    }

    /**
     * アプリケーションの初期化
     */
    protected function initialize(): void
    {
        // TODO: use文を書いておくべき？？
        
        $this->request    = new Request();
        $this->response   = new Response();
        // TODO: 未実装
        // $this->session    = new Session();
        $this->db_manager = new DbManager();
        $this->router     = new Router($this->registerRoutes());
    }

    /**
     * アプリケーションの設定
     */
    protected function configure(): void
    {
    }

    public function run()
    {
        $params = $this->router->resolve($this->request->getPathInfo);
        if ($params === false) {
            //  todo-A
        }

        $controller = $params['controller'];
        $action = $params['action'];

        $this->runAction($controller, $action, $params);

        $this->response->send();
    }

    public function runAction($controller_name, $action, $params = [])
    {
        $controller_class = ucfirst($controller_name).'Controller';
        $controller = $this->findController($controller_class);
        if ($controller === false) {
            // todo-B
        }
        $content = $controller->run($action, $params);
        $this->response->setContent($content);
    }

    public function findController($controller_class)
    {
        if (!class_exists($controller_class)) {
            $controller_file = $this->getControllerDir(). '/' . $controller_class . '.php';  

            if (!is_readable($controller_file)) {
                return false;
            } else {
                require_once $controller_file;
                if (!class_exists($controller_class)) {
                    return false;
                }
            }
        }

        return new $controller_class($this);
    }


    /**
     * ルーティング
     */
    abstract public function getRootDir();
    abstract protected function registerRoutes();

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

    // TODO; 疎通確認用
    public function run__test()
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

    public function getControllerDir()
    {
        return $this->getRootDir(). '/controllers';
    }

    public function getViewDir()
    {
        return $this->getRootDir(). '/views';
    }

    public function getModelDir()
    {
        return $this->getRootDir(). '/models';
    }

    public function getWebDir()
    {
        return $this->getRootDir(). '/web';
    }

}