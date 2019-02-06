<?php

namespace Tests\Unit;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test retrieve category model
     *
     * @return void
     */
    public function testGetCategory()
    {
        $category = Category::find(1);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals(1, $category->id);
        $this->assertEquals('Brakes', $category->category);
    }
}
