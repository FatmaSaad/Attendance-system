<?php

namespace Tests\Feature\FrontApi;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

abstract class FrontApiTestCase extends ApiTestCase
{
    use WithFaker;

    /**
     * Route of test case
     *
     * @var string
     */
    protected $route;

    /**
     * Route of test case
     *
     * @var string
     */
    protected $attributes;
    /**
     * Route of test case
     *
     * @var string
     */

    protected function generalAttributes($full_attribute, $missing = []): array
    {
        return array_diff_key($full_attribute, array_flip($missing));
    }
    /**
     * Define the response shape will be returned
     *
     * @return array
     */
    abstract protected function responseShape(): array;
    /**
     * Fail unAuthenticated user GET request
     *
     * @return void
     */
    protected function failGet($uri = '')
    {
        $route = $this->route . $uri;
        $response = $this->get($route);
        $response->assertStatus(401);
    }
    /**
     * Fail unAuthenticated user POST request
     *
     * @return void
     */
    protected function failPost($attributes, $uri = '')
    {

        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(401);
    }

    /**
     * Fail unAuthenticated user POST request
     *
     * @return void
     */
    protected function failUpdate($attributes, $uri = '')
    {
        $route = $this->route . $uri;
        $response = $this->put($route, $attributes);
        $response->assertStatus(302);
    }

    /**
     * success authenticated user GET request
     *
     * @return void
     */
    protected function successGet($responseShape, $uri = '')
    {

        $user = Sanctum::actingAs(
            User::all()->random(),
            ['*']
        );
        $route = $this->route . $uri;
        $response = $this->get($route);
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($responseShape) {
            $data = Arr::dot($responseShape);
            foreach ($data as $key => $value) {
                $json->whereType('data.' . $key, $value);
            }

            $json->etc();
        });
    }

    /**
     * success authenticated user POST request
     *
     * @return void
     */
    protected function successPost($attributes, $uri = '', $tableName = null)
    {

        $user = Sanctum::actingAs(
            User::all()->random(),
            ['*']
        );
        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(200);
        if ($tableName != null) {
            $this->assertDatabaseHas($tableName, $attributes);
        }
    }

    /**
     * success authenticated user POST request
     *
     * @return void
     */
    protected function successGuestPost($attributes, $uri = '', $tableName = null, $dataBaseMissing = [])
    {

        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(200);
        if ($tableName != null) {
            //if($attributes['password']) $attributes['password']=Hash::make($attributes['password']);;
            $this->assertDatabaseHas(
                $tableName,
                array_diff_key($attributes, array_flip($dataBaseMissing))
            );
        }
    }

    /**
     * Fail Validation POST request
     *
     * @return void
     */
    protected function failValidationPost($attributes, $uri = '', $tableName = null)
    {
        $user = Sanctum::actingAs(
            User::all()->random(),
            ['*']
        );
        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(422);
        $this->assertDatabaseMissing($tableName, $attributes);
    }
    /**
     * Fail Validation POST request
     *
     * @return void
     */
    protected function failGuestValidationPost($attributes, $uri = '', $tableName = null, $dataBaseMissing = [])
    {

        
        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(422);
        if ($tableName != null) {
            $this->assertDatabaseHas(
                $tableName,
                array_diff_key($attributes, array_flip($dataBaseMissing))
            );
        }

    }
    /**
     * Fail Validation POST request
     *
     * @return void
     */
    protected function failGuestValidationPostWithoutDatabaseCheck($attributes, $uri = '')
    {

        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(422);
    }
    /**
     * success authenticated user Update request
     *
     * @return void
     */
    protected function successUpdate($attributes, $uri = '', $table, $redirectRoute, $foreignKeys = [])
    {

        $route = $this->route . $uri;
        $response = $this->put($route, $attributes);
        // dd($route, $response);
        // $response->assertStatus(302)->assertRedirect(route($redirectRoute));
        $this->assertDatabaseHas($table, $this->generalAttributes($attributes, $foreignKeys));
    }   /**
        * Fail Validation Update request
        *
        * @return void
        */
    protected function failValidationUpdate($attributes, $route, $table, $uri = '')
    {
        // login as Client
        $user = $this->loginAsClient();
        $route = $route . $uri;
        $response = $this->put($route, $attributes, [
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseMissing($table, $attributes);
    }

}
