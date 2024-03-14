<?php
declare(strict_types=1);

namespace tests\unit;

use App\Service\SampleAService;
use PHPUnit\Framework\TestCase;

class SampleAServiceTest extends TestCase
{
    protected $SampleService;

    public function setUp(): void
    {
        parent::setUp();
        $this->SampleService = new SampleAService();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->SampleService);
    }

    /**
     * @test
     */
    public function index_返却値の文字列が正しい事を検証()
    {
        $this->assertEquals('This is sample A', $this->SampleService->index());
    }

}