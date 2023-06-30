<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $user = User::first();

        $this->actingAs($user);
    }

    /** @test */
    public function canRenderTheDashboardMainPage()
    {
        $response = $this->get('/dashboard');

        $response->assertOk();
    }
}
