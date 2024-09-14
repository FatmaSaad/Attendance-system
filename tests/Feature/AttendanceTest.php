<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DateInterval;
use DateTime;
use Tests\Feature\FrontApi\FrontApiTestCase;

class AttendanceTest extends FrontApiTestCase
{

    // use RefreshDatabase;
    /**
     * {@inheritDoc}
     */
    protected $route = '/api/attendance';
    protected $full_attribute = [];

    /**
     * {@inheritDoc}
     */
    protected function responseShape(): array
    {
        return [
            '0.check_in_date' =>  'string',
            '0.check_out_date' => 'string',
          
        ];
    }
  
    protected function attributes($missing = []): array
    {
        $fromAttribute= $this->faker->dateTimeThisYear();

        $full_attribute = array(
            'from' => $fromAttribute->format('Y-m-d'),
            'to' => $fromAttribute->add(DateInterval::createFromDateString(rand(1, 8).' week'))->format('Y-m-d')
        );
        return array_diff_key($full_attribute, array_flip($missing));
    }

    /*---------------------------- Fail Cases For UnAuthenticated User-------------------------------------------*/

    /**
     * Test Case for Get response 
     * and assert THIS ACTION IS UNAUTHORIZED 401
     *
     * @return void
     */
    public function test_unauth_get_response()
    {
        $this->failGet();
    }
    
    /**
     * Test Case for POST response 
     * and assert THIS ACTION IS UNAUTHORIZED 401
     *
     * @return void
     */
    public function test_unauth_post_response()
    {
        $this->failPost($this->attributes());
    }
    
   
    // /*---------------------------- Success Cases -------------------------------------------*/

    /**
     * Test Case for get response 
     * and make sure the response shape
     *
     * @return void
     */
    public function test_get_response()
    {
        $this->successGet($this->responseShape());
    }
    /**
     * Test Case for POST response 
     * and make sure the response shape
     *
     * @return void
     */
    public function test_post_response()
    {
        $this->successPost($this->attributes() );
    }

    /*---------------------------- Fail Cases For Data Missing Validation-------------------------------------------*/

    // /**
    //  * Test Case for POST response to make sure all required attributes send successfully
    //  *
    //  * @return void
    //  */
    // public function test_validation_post_response()
    // {
    //     $this->failValidationPost($this->attributes(['from'])   );
    // }
    // /**
    //  * Test Case for POST response to make sure all required attributes send successfully
    //  *
    //  * @return void
    //  */
    // public function test_validation2_post_response()
    // {
    //     $this->failValidationPost($this->attributes(['to']));
    // }

    /*---------------------------- Fail Cases For Data Missing Validation-------------------------------------------*/

   
}
