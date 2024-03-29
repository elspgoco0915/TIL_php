<?php
declare(strict_types=1);

class ClassLoader
{
    protected array $dirs;

    /**
     * オートローダクラスを登録する
     * オートロード時に$this->loadClass()を呼ぶ
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * ディレクトリを登録する
     * オートロードの対象とするディレクトリのフルパスを指定する
     * @return void
     */
    public function registerDir($dir): void
    {
        $this->dirs[] = $dir;
    }

    /**
     * クラスファイルの読み込み
     * オートロード時に呼び出され、dirsのディレクトリから"{クラス名}.php"を探し、ある場合はrequireで読み込む
     * @return void
     */
    public function loadClass($class): void
    {
        // TODO: デバッグ用のなので消す
        var_dump($class);

        foreach ($this->dirs as $dir) {
            $file = "{$dir}/{$class}.php";
            if (is_readable($file)) {
                require_once $file;
            }
        }

    }
}