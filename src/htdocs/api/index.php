<?php
// API用の文字コードなどの設定
header('Content-Type: application/json; charset=UTF-8');

// クエリパラメータ(?num=数字)が設定されていなかったら、0を返す
if (empty($_GET['num']) || $_GET['num'] === '') {
    $num = 0;
// クエリパラメータが設定されていたら(?num=数字)を取得する
} else {
    $num = $_GET['num'];
}

// フロントに返したい結果を配列で用意する
$array = [
    'status' => 200,
    'message' => "hello! number is ".$num."!!",
];

// フロントで扱えるように、配列をjsonにして出力する
echo json_encode($array);