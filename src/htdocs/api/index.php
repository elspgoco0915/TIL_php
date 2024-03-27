<?php
// 文字コード設定
header('Content-Type: application/json; charset=UTF-8');

$num = $_GET['num'] ?? 'none';

$array = [
    'status' => 200,
    'message' => "hello!number is ".$num."!!",
];

echo json_encode($array);