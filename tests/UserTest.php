<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function test(){

    	$this->visit('/')
         ->click('Login')
         ->seePageIs('/login');

    }

    public function test2(){

    	$this->visit('/')
         ->click('Register')
         ->type('Antoine', 'name')
         ->type('antoine.dessauges2@cpnv.ch', 'email')
         ->type('123456', 'password')
         ->type('123456', 'password_confirmation')
         ->press('Register User')
         ->seePageIs('/home');
         
    }

}
