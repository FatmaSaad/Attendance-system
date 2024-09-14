<?php

namespace Tests\Feature\Auth\RegisterTest;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DateInterval;
use DateTime;
use Tests\Feature\FrontApi\FrontApiTestCase;

class RegisterTest extends FrontApiTestCase
{

    // use RefreshDatabase;
    /**
     * {@inheritDoc}
     */
    protected $route = '/api/register';
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
        ];
    }
    protected function attributes($missing = []): array
    {
        $full_attribute = array(
            'user_id' => $this->faker->numerify(),
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email(),
            'password' =>'123456',
            'password_confirmation' => '123456'

        );
        return array_diff_key($full_attribute, array_flip($missing));
    }



    /**
     * Test Case for POST response 
     * and make sure the response shape
     *
     * @return void
     */
    public function test_user_can_register_with_correct_credentials()
    {
        $this->successGuestPost($this->attributes(), null, 'users', ['password', 'password_confirmation']);
    }
   


    /*---------------------------- Fail Cases For Data Missing Validation-------------------------------------------*/

    /**
     * Test Case for POST response to make sure all required attributes send successfully
     *
     * @return void
     */
    public function test_validation_post_response()
    {
        $this->failGuestValidationPost($this->attributes(['user_id', 'password_confirmation']), null, null,['password', 'password_confirmation']);
    }
    /**
     * Test Case for POST response to make sure all required attributes send successfully
     *
     * @return void
     */
    public function test_validation2_post_response()
    {
        $this->failGuestValidationPost($this->attributes(['email', 'password_confirmation']), null, null,['password', 'password_confirmation']);
    }

    /*---------------------------- Fail Cases For Data Missing Validation-------------------------------------------*/


}
