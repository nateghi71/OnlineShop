<?php

namespace Tests\Feature;

use App\Models\Attribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_create_attribute(): void
    {
        $attributes = Attribute::factory()->count(11)->create();
        $this->assertDatabaseHas('attributes' , $attributes->toArray());
    }
}
