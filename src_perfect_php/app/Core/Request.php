<?php
declare(strict_types=1);

class Request 
{
    /**
     * HTTPメソッドがPOSTか判定する
     * @return bool
     */
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST'; 
    }

    /**
     * $_GET変数を取得する
     * @return mixed
     */
    public function getGet($name, $default = null): mixed
    {
        return $_GET[$name] ?? $default;
    }

    /**
     * $_POST変数を取得する
     * @return mixed
     */
    public function getPost($name, $default): mixed
    {
        return $_POST[$name] ?? $default;
    }

    /**
     * サーバのホスト名を取得する
     * $_SERVER['HTTP_HOST']にはHTTPリクエストヘッダに含まれるホストの値が格納されている
     * リクエストヘッダに含まれていな場合、Apache側に設定されたホスト名が格納されている$_SERVER['SERVER_NAME']を取得する
     * @return string
     */
    public function getHost(): string
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * HTTPSでアクセスされたかどうかを判定する
     * @return bool
     */
    public function isSsl(): bool
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    }

    /**
     * URLのホスト部分以降の値を返す
     */
    public function getRequestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * ベースURLを特定する
     * ex: 
     *  http://example.com/foo/bar/list
     *  "foo/bar"がベースURL
     * 
     * @return string
     */
    public function getBaseUrl(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $requestUri = $this->getRequestUri();
        
        // フロントコンローラーがURLに含まれる場合
        if (strpos($requestUri, $scriptName) === 0) {
            return $scriptName;
        // フロントコントローラが省略されている場合
        } else if (strpos($requestUri, dirname($scriptName)) === 0) {
            return rtrim(dirname($scriptName), '/');
        }
        return '';
    }

    /**
     * PATH_INFOの特定
     * ex: 
     *  http://example.com/foo/bar/list
     *  "/list"がPATH_INFO
     * 
     * @return string
     */
    public function getPathInfo(): string 
    {
        $baseUrl = $this->getBaseUrl();
        $requestUri = $this->getRequestUri();
        // クエリパラメータを取り除く処理
        if (!($pos = strpos($requestUri, '?'))) {
            $requestUri = substr($requestUri, 0, $pos);
        }

        $pathInfo = (string) substr($requestUri, strlen($baseUrl));
        return $pathInfo;
    }


}