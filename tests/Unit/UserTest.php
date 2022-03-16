<?php

namespace Tests\Unit;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_delete()
    {
        $user = $this->makeUser();

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'email' => $user->email,
            'name' => $user->name
        ]);
    }

    public function test_update()
    {
        $faker = Faker::create();

        $user = $this->makeUser();

        $data = [
            'name' => $faker->name,
            'email' => $faker->email
        ];

        $user->update($data);

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertNotEmpty($user->password);
    }

    public function test_create()
    {
        $faker = Faker::create();

        $email = $faker->email;

        $user = $this->makeUser($name = 'name', $email,  $password = 'password');
        $lastUser = User::query()->orderByDesc('id')->first();

        if ($lastUser->email != $user->email) {
            $this->fail();
        }

        $this->assertNotEmpty($user);

        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
    }

    public function makeUser($name = null, $email = null, $password = null)
    {
        $faker = Faker::create();

        $user = User::query()->create([
            'name' => $name ?? $faker->name,
            'email' => $email ?? $faker->unique()->safeEmail,
            'password' => $password ? Hash::make($password) : '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
        ]);

        if (! $user) {
            $this->fail();
        }

        return $user;
    }

    public function test_get_users()
    {
        $response = $this->get("api/users/");

        $response->assertStatus(200);
    }

    public function test_get_one_user()
    {
        $user = User::first();

        $response = $this->get("api/users/{$user->id}");

        $response->assertStatus(200);
    }
}
