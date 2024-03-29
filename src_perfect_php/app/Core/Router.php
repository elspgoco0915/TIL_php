<?php
declare(strict_types=1);

class Router
{
    protected $routes;

    public function __construct($definitions)
    {
        $this->routes = $this->complieRoutes($definitions);
    }

    /**
     * ルーティング定義配列のそれぞれのキーに含まれる動的パラメータを正規表現でキャプチャできる形式に変換
     * @return array
     */
    public function complieRoutes($definitions): array
    {
        $routes = [];

        foreach ($definitions as $url => $params) {
            $tokens = explode('/', ltrim($url, '/'));
            foreach($tokens as $i => $token) {
                if (strpos($token, ':') === 0) {
                    $name = substr($token, 1);
                    // NOTE: 名前付きキャプチャ（?P<foo>{対象の文字列}）
                    $token = '(?P<)'.$name . '>[^/]+)';
                }
                $tokens[$i] = $token;
            }
            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }
        return $routes;
    }

    /**
     * マッチングを行う
     * @return mixed
     */
    public function resolve($pathInfo): mixed
    {
        // PATH_INFOの先頭がスラッシュでない場合、先頭にスラッシュを付与
        if (substr($pathInfo, 0, 1) === '/') {
            $pathInfo = '/' . $pathInfo;
        }

        foreach ($this->routes as $pattern => $params) {
            // 正規表現でマッチングする
            if (preg_match('#^'.$pattern.'$#', $pathInfo, $matches)) {
                // マッチングした場合、ルーティングパラメータとして格納して返す
                $params = array_merge($params, $matches);
                return $params;
            }
        }
        return false;
    }
}