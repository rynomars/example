<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Item;
use Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * Test create Item
     *
     * @return void
     */
    public function testItemCreate()
    {
        $data = [
            'status' => Item::STATUS_DRAFT,
            'part_number' => str_random(12),
            'brand_id' => str_random(4),
            'category_id' => 1
        ];

        $item = new Item();
        $item->status = $data['status'];
        $item->part_number = $data['part_number'];
        $item->brand_id = $data['brand_id'];
        $item->category_id = $data['category_id'];
        $item->save();

        $this->assertDatabaseHas('items', $data);
        $this->assertInstanceOf(Category::class, $item->category);
    }

    /**
     * Test create Item without part
     *
     * @return void
     */
    public function testItemCreateWithoutPartNumber()
    {
        $this->expectExceptionMessage('A part number is required to save item');

        $data = [
            'status' => Item::STATUS_DRAFT,
            'brand_id' => str_random(4)
        ];

        $item = new Item();
        $item->brand_id = $data['brand_id'];
        $item->save();
    }

    /**
     * Test create Item without status
     *
     * @return void
     */
    public function testItemCreateWithoutStatus()
    {
        $this->expectExceptionMessage('A status is required to save item');

        $data = [
            'status' => Item::STATUS_DRAFT,
            'part_number' => str_random(12),
            'brand_id' => str_random(4)
        ];

        $item = new Item();
        $item->part_number = $data['part_number'];
        $item->brand_id = $data['brand_id'];
        $item->save();
    }

    /**
     * Test create Item without brand_id
     *
     * @return void
     */
    public function testItemCreateWithoutBrandId()
    {
        $this->expectExceptionMessage('A brand id is required to save item');

        $data = [
            'status' => Item::STATUS_DRAFT,
            'part_number' => str_random(12),
            'brand_id' => str_random(4)
        ];

        $item = new Item();
        $item->status = $data['status'];
        $item->part_number = $data['part_number'];
        $item->save();
    }
}
