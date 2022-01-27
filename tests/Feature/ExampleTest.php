<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * How to add logs
     */
    public function test_add_some_log(){
        $this->json('GET', 'api/test-log')
        ->assertOk()
        ->assertJson([
            "message" => "log created, go to storage\logs to see the logs"
        ]);
    }

    /**
     * How to obtain key from ENV
     */
    public function test_obtain_key_from_env(){
        $this->json('GET', 'api/test-key')
        ->assertOk()
        ->assertJson([
            "message" => "This is key obtained :1234567890123456789qwerty "
        ]);
    }






    /**
     * Attacker attempt to change salary value to RM 10
     * Prevent mass assignment
     *
     */
    public function test_mass_assignable_salary_fail()
    {
        $this->json('POST', 'api/mass-assignable', [
            "user_id" => 1,
            "salary" => "10"
        ])
        ->assertOk()
        ->assertJson([
            "user_id" => 1,
            "salary" => "4000",
        ]);
    }
}
