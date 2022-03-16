<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\AppealController;
use App\Models\Appeal;
use App\Models\Category;
use Faker\Factory as Faker;
use Tests\TestCase;

class AppealTest extends TestCase
{
    public function test_create()
    {
        $this->makeAppeal($title = 'testTitle', $description = 'testDescription');
        $appeal = Appeal::query()->orderByDesc('id')->firstOrFail();

        $this->assertNotEmpty($appeal);

        $this->assertEquals($title, $appeal->title);
        $this->assertEquals($description, $appeal->description);
    }

    public function test_delete()
    {
        $appeal = $this->makeAppeal();

        $this->assertNotEmpty($appeal);

        $controller = new AppealController();
        $response = $controller->delete($appeal->id);

        $this->assertEmpty($response);
    }

    public function test_update()
    {
        $faker = Faker::create();

        $category = $this->makeCategory();
        $appeal = $this->makeAppeal();

        $this->assertNotEmpty($appeal);

        $title = $faker->text(5);

        $data = [
            'title' => $title,
            'description' => $faker->text(50),
            'category_id' => $category->id,
        ];

        $this->json('POST', "api/appeals/{$appeal->id}", $data)
            ->assertStatus(200);
    }

    public function makeCategory($title = null, $description = null, $is_publish = null)
    {
        $faker = Faker::create();

        $categoryTitle = $faker->jobTitle;

        return Category::query()->create([
            'title' => $title ?? $categoryTitle,
            'description' => $description ?? strtoupper($categoryTitle),
        ]);
    }

    public function makeAppeal($title = null, $description = null)
    {
        $faker = Faker::create();

        $category = $this->makeCategory();

        return Appeal::query()->create([
            'title' => $title ?? $faker->jobTitle,
            'description' => $description ?? 'описание описание описание',
            'category_id' => $category->id,
        ]);
    }


    public function test_get_apeals()
    {
        $response = $this->get("api/appeals/");

        $response->assertStatus(200);
    }

    public function test_get_one_apeal()
    {
        $appeal = Appeal::first();

        $response = $this->get("api/appeals/{$appeal->id}");

        $response->assertStatus(200);
    }
}
