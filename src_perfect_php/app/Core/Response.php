<?php
declare(strict_types=1);

class Response
{
    protected $content;
    protected $statusCode = 200;
    protected $statusText = 'OK';
    protected $httpHeaders = [];

    // TODO: 型付け
    /**
     * 各プロパティに設定された値を元にレスポンスの送信をする
     */
    public function send()
    {
        // TODO: HTTPを最新にする
        // ステータスコードの指定
        header('HTTP/1.1 '.$this->statusCode.' '.$this->statusText);
        // 
        foreach ($this->httpHeaders as $name => $value) {
            header($name.': '.$value);
        }
        // レスポンス内容の送信
        echo $this->content;
    }

    /**
     * HTMLなどのクライアントに返す内容を格納
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * HTTPのステータスコードを格納
     */
    public function setStatusCode($statusCode, $statusText = ''): void
    {
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }

    /**
     * HTTTPヘッダを格納
     */
    public function setHttpHeader($name, $value): void
    {
        $this->httpHeaders[$name] = $value;
    }
}