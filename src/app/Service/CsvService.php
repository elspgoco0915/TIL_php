<?php
declare(strict_types=1);

namespace App\Service;

class CsvService {

    public function index()
    {
        $this->readCsv();
    }

    public function readCsv()
    {
        $tmpFileName = tempnam(sys_get_temp_dir(), 'test');
        var_dump($tmpFileName);
        exit;
        
    }

}