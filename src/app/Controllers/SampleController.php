<?php
namespace App\Controllers;

class SampleController
{
    public function index()
    {
        var_dump('SampleController - index');
        echo $_ENV['SAMPLE_ENV'];
        exit;
    }
}