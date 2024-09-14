<?php

namespace Tests\Feature\Auth\RegisterTest;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\FrontApi\FrontApiTestCase;

class LoginTest extends FrontApiTestCase
{
    // $this->assertAuthenticated();
    // use RefreshDatabase;
    /**
     * {@inheritDoc}
     */
    protected $route = '/api/login';
    protected $full_attribute = [];

    /**
     * {@inheritDoc}
     */
    protected function responseShape(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'email' => 'string',
            'status' => 'string',
            'user_id' => 'integer',
            'token' => 'string',
        ];
    }
    protected function attributes($missing = []): array
    {
        $full_attribute = array(
            'user_id' =>$this->faker->numerify(),
            'password' =>   '123456',
            
        );
        return array_diff_key($full_attribute, array_flip($missing));
    }


   
    /**
     * Test Case for POST response 
     * and make sure the response shape
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::Factory()->create([
            'password' => bcrypt($password=$this->attributes()['password']),
        ]);

        $this->attributes['user_id']=$user->user_id;
        $this->attributes['password']=$password;

        $response = $this->post($this->route,
         $this->attributes);
        
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    /*---------------------------- Fail Cases For Data Missing Validation-------------------------------------------*/

    /**
     * Test Case for POST response to make sure all required attributes send successfully
     *
     * @return void
     */
    public function test_validation_post_response()
    {
        $this->failGuestValidationPost($this->attributes(['user_id']  ));
    }
    /**
     * Test Case for POST response to make sure all required attributes send successfully
     *
     * @return void
     */
    public function test_validation2_post_response()
    {
        $this->failGuestValidationPost($this->attributes(['password']) );
    }

    /*---------------------------- Fail Cases For Data Missing Validation-------------------------------------------*/

   
}
