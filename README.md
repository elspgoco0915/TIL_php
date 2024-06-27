# これは何
- 超シンプルAPI
- フレームワークなどを使わずフロントとバックの関係を確認するもの

## クローンの仕方
- プロジェクトファイルを展開したい任意の場所に移動します
- 以下コマンドを入力します
  - (クローンして、クローンしたプロジェクトに移動して、超シンプルAPIのbranchに移動をやっています)
``` bash
git clone https://github.com/elspgoco0915/TIL_php.git
cd TIL_php/
git checkout super-simple-api
```

## docker起動の仕方
- クローンしたプロジェクトで以下のコマンドでdockerディレクトリに移動し、以下のdockerコマンドを入力します
```bash
cd ./docker/
docker-compose up -d --build
```

## ディレクトリ構成
- docker
  - docker関連ファイルなので特に気にせず
- src
  - ここがプロジェクトファイルなので、動いてるのはこれだけ
- その他
  - 特に気にしないでください

## アクセスの仕方
- [localhost:8080](http://localhost:8080/)