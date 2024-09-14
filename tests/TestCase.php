<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    // it will automatically rollback all database transactions made during your tests.

    // use RefreshDatabase; // In Fact it will drop all tables and migrate again. If you would not loose your data you can use one separate schema for test.
    public function setUp(): void
    {
        parent::setUp();

        // seed the database
       
         $this->seed();
    }


}
