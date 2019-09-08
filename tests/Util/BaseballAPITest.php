<?php

namespace App\Tests\Util;

use PHPUnit\Framework\TestCase;
use App\Util\BaseballAPI;

class BaseballAPITest extends TestCase
{
    public function test_MockObject(){

        $baseball = $this->createMock(BaseballApi::class);

        $baseball->expects($this->any())
            ->method('submitAtBat')
            ->willReturn(true);

        $result = $baseball->submitAtBat('1', 'bn');

        $expected = true;

        $this->assertEquals($expected, $result);

    }

    //same, but with Mockery sintax
    public function testMockery()
    {
        $baseball = new BaseballAPI();

        $mockeryMock = \Mockery::mock(BaseballAPI::class);

        $mockeryMock->allows()->submitAtBat('1', 'bh')->once()->andReturn(true);

        $this->assertEquals(true, $baseball->submitAtBat('1', 'nh'));
    }
}