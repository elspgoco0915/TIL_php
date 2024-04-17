## 内容
- [ ]  学んだことをプログラムを書いてアウトプット

### 全体の環境構成イメージ
#### feature/#1/create_env
- [x]  FWを使わないOOP PHPで少しだけ幸せになる〜オブジェクト指向/無印PHPプログラミングTips〜
    https://www.ritolab.com/posts/172#%E3%82%B3%E3%83%B3%E3%83%88%E3%83%AD%E3%83%BC%E3%83%A9%E4%BD%9C%E6%88%90
  - [x]  無印ちゃんは「名前空間」を掌握したい
  - [x]  composer.json 作成
  - [x]  コントローラ作成
  - [x]  無印ちゃんは「環境変数」を env ファイルで管理したい
  - [x]  無印ちゃんは「Configure クラス」を使いたい
  - [x]  無印ちゃんは「DI コンテナ」を入れたい
  - [x]  無印ちゃんは「ユニットテスト」を走らせたい
- [ ]  docker-compose時にsqlを実行してテーブルを用意する

#### feature/#3/create_env_on_perfect_php (仮)
- [ ]  パーフェクトPHP全乗せ
  - [ ]  php8解釈で作る
  - [ ]  DBの疎通
  - [ ]  7章フレームワークを作り切る
  - [ ]  8章ミニブログ、9章のセキュリティは別途イシューで
- 7章残class
  - core/Session
  - core/Application
  - core/HttpNotFoundException
  - core/Controller
  - core/View

## 学習内容
- [ ]  超基礎PHP
  - [ ]  バシャログ
  - [ ]  他にもあった気がする（スプレッドシート）
- [ ]  ソフトウェア設計
  - [ ]  Head first design pattern
  - [ ]  軽量ddd
- [ ]  SQL
  - [ ]  SQLアンチパターン
  - [ ]  SQL100本ノック
  - [ ]  （git100本ノックはここに書いても感はある）
- [ ]  細かな項目
  - [ ] data-uriとfetchAPIの活用
  - [ ] HTML5では、data-* の書式でカスタム属性 ( Custom Data Attribute )を定義できるらしい
  - [ ] キャッシュの活用方法
    - [ ] ex: メニューバーの通知などをDBで取得し、以降はキャッシュにするとか？
  - [ ] モジュール(modules)の構造 
  - [ ]  BIT演算
  - [ ]  array shapes記法などの配列の型
    - [x]  可変超引数を用いて、配列中身のタイプヒント
    - [ ]  ArrayObjectでタイプヒント
    - [ ]  DTO
      - [ ] [配列を捨てよう！](https://speakerdeck.com/uzulla/throw-away-all-php-array-now?slide=46)
    - [ ]  ジェネレーター
  - [x] Enum
  - [ ] ogp
- [ ]  ツール
  - [ ] daemon
  - [ ]  PHPUnit
  - [ ]  cron
- [ ]  docker
  - [ ]  mailcatcher載せてみる
  - [ ]  キャッシュ関連(redis)
- [ ]  セキュリティ
  - [ ]  体系的に学ぶ 安全なWebアプリケーションの作り方

## そのほか
- [ ]  [質問されたことを実践メモ](https://docs.google.com/spreadsheets/d/1g8SDqkLkDOcW66t0IXxamGLy_yV_lqq-ghzukjVk64/edit#gid=0)
- [ ]  [タスク群は時間作って消化するのもよき](https://docs.google.com/spreadsheets/d/1WIR4vQxEMOXrPJ3PWPmqJyNMYYOWu_7jIl7-0qJ9GA/edit#gid=0)
- [ ]  

### modelを考える案
- シングルトンパターンで、PDOクラスは同じものを使い回す
  - そのclassをModelで継承ではなくDIを使いたい？
- さらに各table用のModelがそのModelを継承

