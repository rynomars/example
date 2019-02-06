<?php

namespace Tests\Feature;

use App\Models\Item;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    /**
     * Test Get Item
     *
     * @return void
     */
    public function testGetItem()
    {
        $item = factory(Item::class)->create();

        $this->json('GET', '/api/items/' . $item->id)->assertOk();
    }


    /**
     * Test Create Item
     */
    public function testCreateItem()
    {
        $status = Item::STATUS_DRAFT;
        $partNumber = str_random(12);
        $brandId = str_random(4);

        $response = $this->json('POST', '/api/items', [
            'status'      => $status,
            'part_number' => $partNumber,
            'brand_id'    => $brandId,
        ])->decodeResponseJson();

        $this->assertTrue($response['success']);
        $this->assertNotEmpty($response['item']['id']);
        $this->assertEquals($response['item']['status'], $status);
        $this->assertEquals($response['item']['part_number'], $partNumber);
        $this->assertEquals($response['item']['brand_id'], $brandId);
    }

    /**
     * Test Update Item
     */
    public function testUpdateItem()
    {
        $item = factory(Item::class)->create([
            'status' => Item::STATUS_DRAFT
        ]);

        $status = Item::STATUS_REVIEW;
        $partNumber = 'ABC123';
        $brandId = 'ZZZZ';

        $response = $this->json('PUT', '/api/items/' . $item->id, [
            'status'      => $status,
            'part_number' => $partNumber,
            'brand_id'    => $brandId,
        ])->decodeResponseJson();

        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['id'], $item->id);
        $this->assertEquals($response['item']['status'], $status);
        $this->assertEquals($response['item']['part_number'], $partNumber);
        $this->assertEquals($response['item']['brand_id'], $brandId);
    }

    /**
     * Test Part Number Lookup
     */
    public function testPartNumberLookup()
    {
        factory(Item::class)->create([
            'part_number' => 'TEST123'
        ]);
        factory(Item::class)->create([
            'part_number' => 'BC567'
        ]);
        factory(Item::class)->create([
            'part_number' => 'TESTING67'
        ]);
        factory(Item::class)->create([
            'part_number' => 'TESTITZDE'
        ]);
        factory(Item::class)->create([
            'part_number' => 'BC5677'
        ]);


        $response = $this->json('GET', '/api/part-number-lookup?part_number=ABC')
            ->assertJsonStructure(['*' => ['id', 'part_number']])
            ->decodeResponseJson();

        /*
         * There should be 3 results
         */
        $this->assertCount(3, $response);
    }
}
