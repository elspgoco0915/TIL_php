<?php
namespace App\Controllers;

use Configure\Configure;

class SampleController
{
    public function index()
    {
        var_dump('SampleController - index');
        echo $_ENV['SAMPLE_ENV'];
        var_dump(Configure::read('app.sample.env'));
        exit;
    }
}