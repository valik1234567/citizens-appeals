<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use Faker\Factory as Faker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_create()
    {
        $this->makeCategory($title = 'title', $description = 'description', $is_publish = true);
        $category = Category::query()->orderByDesc('id')->firstOrFail();

        $this->assertNotEmpty($category);

        $this->assertEquals($title, $category->title);
        $this->assertEquals($description, $category->description);
    }

    public function test_delete()
    {
        $category = $this->makeCategory();

        $this->assertNotEmpty($category);

        $controller = new CategoryController();
        $response = $controller->delete($category->id);

        $this->assertEmpty($response);
    }

    public function test_update()
    {
        $faker = Faker::create();

        $category = $this->makeCategory();

        $this->assertNotEmpty($category);

        $title = $faker->text(5);

        $data = [
            'title' => $title,
            'description' => $faker->text(50),
        ];

        $this->json('POST', "api/categories/{$category->id}", $data)
            ->assertStatus(200);
    }

    public function makeCategory($title = null, $description = null, $is_publish = null)
    {
        $faker = Faker::create();

        $categoryTitle = $faker->jobTitle;

        return Category::query()->create([
            'title' => $title ?? $categoryTitle,
            'description' => $description ?? strtoupper($categoryTitle),
            'is_publish' => $is_publish ?? $faker->boolean(),
        ]);
    }


    public function test_get_categories()
    {
        $response = $this->get("api/categories/");

        $response->assertStatus(200);
    }

    public function test_get_one_category()
    {
        $category = Category::first();

        $response = $this->get("api/categories/{$category->id}");

        $response->assertStatus(200);
    }
}
