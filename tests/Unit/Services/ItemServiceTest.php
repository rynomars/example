<?php

namespace Tests\Unit\Services;

use App\Services\Contracts\ItemServiceInterface;
use App\Services\ItemService;
use Tests\TestCase;

class ItemServiceTest extends TestCase
{
    /**
     * Test that the ItemServiceProvider returns instance of ItemService
     *
     * @return void
     */
    public function testItemServiceInterfaceReturnsInstanceOfItemService()
    {
        $itemService = $this->app->make(ItemServiceInterface::class);
        $this->assertInstanceOf(ItemService::class, $itemService);
    }
}
