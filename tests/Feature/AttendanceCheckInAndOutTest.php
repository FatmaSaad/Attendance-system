<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DateInterval;
use DateTime;
use Tests\Feature\FrontApi\FrontApiTestCase;

class AttendanceCheckInAndOutTest extends FrontApiTestCase
{

    // use RefreshDatabase;
    /**
     * {@inheritDoc}
     */
    protected $route = '/api';
    protected $full_attribute = [];

    /**
     * {@inheritDoc}
     */
    protected function responseShape(): array
    {
        return [
            'status' => 'string',
            'check_in_date' =>  'string',
        ];
    }
  


    /*---------------------------- Fail Cases For UnAuthenticated User-------------------------------------------*/

    
    /**
     * Test Case for POST response 
     * and assert THIS ACTION IS UNAUTHORIZED 401
     *
     * @return void
     */
    public function test_unauth_check_in_response()
    {
        $this->failGet('/check_in');
    }
        /**
     * Test Case for POST response 
     * and assert THIS ACTION IS UNAUTHORIZED 401
     *
     * @return void
     */
    public function test_unauth_check_out_response()
    {
        $this->failGet('/check_out');
    }
   
    // /*---------------------------- Success Cases -------------------------------------------*/

    /**
     * Test Case for get response 
     * and make sure the response shape
     *
     * @return void
     */
    public function test_check_in_response()
    {
        $this->successGet($this->responseShape(),'/check_in');
    }
  
        /**
     * Test Case for get response 
     * and make sure the response shape
     *
     * @return void
     */
    public function test_check_out_response()
    {
        $this->successGet(array_merge($this->responseShape(),['check_out_date'=>'string','attendance_hours'=>'string']),'/check_out');
    }
   
}
