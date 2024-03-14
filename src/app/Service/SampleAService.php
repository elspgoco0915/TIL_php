<?php
declare(strict_types=1);

namespace App\Service;

use App\Controllers\SampleInterface;

class SampleAService implements SampleInterface
{
    public function index(): string
    {
        return 'This is sample A';
    }
}