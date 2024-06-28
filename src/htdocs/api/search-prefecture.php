<?php
// API用の文字コードなどの設定
header('Content-Type: application/json; charset=UTF-8');

/**
 * バリデーションもどき
 */
// バリデーションもどき

// 失敗用に返す配列
$failed_array = [
    'status'     => 500,
    'message'    => '入力値のエラーです',
    'prefecture' => 'エラー',
];

// 入力がない場合、エラーを返して終了
if (empty($_GET['num']) || $_GET['num'] === '') {
    echo json_encode($failed_array);
    exit;
}

// 桁数が7桁じゃなかったら、エラーを返して終了
if (mb_strlen($_GET['num']) !== 7) {
    echo json_encode($failed_array);
    exit;
}
// エラーがなかったら変数に格納して処理を続ける
$num = $_GET['num'];


/**
 * 外部APIをcurlでリクエストして結果を取得する
 */
// curlで外部WebAPIを叩く
// 参考: PHPでHTTPリクエスト(https://qiita.com/tokutoku393/items/3c3ba3ca581bc0381e35)
$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=".$num;
// curlの処理を起動
$curl = curl_init($url);
// リクエストのオプションをセットしていく
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');  // メソッド指定
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // レスポンスを文字列で受け取る
// curlを実行して、レスポンス結果(json文字列)を取得する
$response_string = curl_exec($curl);
// curlの処理を終了
curl_close($curl);
// 外部APIのレスポンス結果json文字列を連想配列に変換する
$response = json_decode($response_string, true);

/**
 * 結果を加工してフロントに返す
 */
// フロントに返したい結果（必要な情報だけ）を配列で用意する
$array = [
    // 外部APIのれすポンス結果のステータスコードを返す(nullの場合は、エラーを示す500を返す)
    'status' => $response["status"] ?? 500,
    // 外部APIを叩いたメッセージ
    'message' => '完了',
    // たとえば、フロントが県名が欲しいので、レスポンス文字列で必要な内容だけ取得（nullの場合は、「該当する県が存在しなかった」旨を伝える）
    'prefecture' => $response["results"][0]["address1"] ?? '存在しません',
];

// フロントで扱えるように、配列をjsonにして出力する
echo json_encode($array);
exit;