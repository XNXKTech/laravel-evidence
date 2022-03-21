<?php

declare(strict_types=1);

namespace Endpoints;

use Tests\TestCase;
use Tests\TestHelpers;

class TempTest extends TestCase
{
    public function testCreatePersonalAccount()
    {
        $response = app(TestHelpers::class)
            ->evidence()
            ->temp()
            ->createBusiness(
                [
                    "房屋租赁行业",
                    "音乐行业",
                ]
            );
        
        $this->assertEquals(0, $response->errCode);
        $this->assertIsObject($response->result);
    }
}