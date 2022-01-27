<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
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


    /**
     * Store user password by one way Hash
     *
     * Validate user by password hash cross check
     */

    public function test_new_user_with_password()
    {
        $name = "new user with number ".random_int(10,200);
        $pass = "9455W0rD_15_535en7iv3";

        $this->json('POST', 'api/user', [
            'name' => $name,
            'email' => "email".random_int(10,100)."@mail.com",
            'password' => $pass
        ])
        ->assertOk()
        ->assertJson([
            "message" =>"user created"
        ]);


        $this->json('POST', 'api/login', [
            'name' => $name,
            'password' => $pass
        ])
        ->assertOk()
        ->assertJson([
            "message" =>"login success",
            "token" => true,
        ]);
    }

    /**
     * Testing global exception handler
     */
    public function test_get_user_handle_exceptions()
    {
        $this->json('GET', 'api/users')
        ->assertStatus(403)
        ->assertJson([
            "message" => "Tindakan tidak dibenarkan , anda tidak mempunyai kebenaran!"
        ]);
    }

    /**
     * Testing input validation
     */
    public function test_validation_prevent_unintended_input()
    {
        $this->json('PUT', 'api/profile', [
            'user_id' => 100,
            'salary' =>  "random string instead of integer"
        ])
        ->assertStatus(422)
        ->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "user_id" => [
                    "The selected user id is invalid."
                ],
                "salary" => [
                    "The salary you know must be integer OK OK OK ???.",
                    "The salary must be between 1000 and 10000."
                ]
            ]
        ]);
    }


    /**
     * Testing policy
     */
    public function test_profile_view_fail_unauthorised_view()
    {
        $user = User::where("id", 1)->first();
        Sanctum::actingAs($user);

        $this->json('GET', 'api/profile/2')
        ->assertStatus(403)
        ->assertJson([
            "message" => "You do not own this profile."
        ]);
    }

    /**
     * Testing token ability
     */
    public function test_user_token_can_remove_profile()
    {
        $user = User::where("id", 1)->first();
        Sanctum::actingAs($user);

        /**
         * Assign role and permission
         *
         */
        $this->json('PUT', 'api/user/1')
        ->assertStatus(200)
        ->assertJson([
            "message" =>"user given admin role & have delete profile permission"
        ]);

        /**
         *
         * Check permission and role given
         *
         */
        $this->json('DELETE', 'api/profile/1')
        ->assertStatus(200)
        ->assertJson([
            "message" => "You can delete this profile"
        ]);
    }


}
