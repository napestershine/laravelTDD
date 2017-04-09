<?php
/**
 * Created by PhpStorm.
 * User: radhasoami
 * Date: 07-04-2017
 * Time: 22:27
 */

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function user_can_login_then_data_valid()
    {
        // we have a setup
        $password = 'secret';
        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => 'email@mail.com',
            'password' => bcrypt($password),
        ]);

        $data = [
            'email' => $user->email,
            'password' => $password,
        ];

        //when we call action
        $response = $this->post(url('login'), $data);
        // if we dont post credentials -we aren't logged in
        $response = $this->get(url('/home'));

        //then we get some response and check against our rules
        $response->assertSee('You are logged in!');
        // everything is fucked up, so have to make 2url requests, and as you can see working
        // so any questions?no :D register also should follow like this approach i guess
    }

    /**
     * @test
     */
    public function user_can_register_and_login_then_datavalid()
    {
        // we have a setup
        $password = 'secret';

        $email = 'email@gmail.com';
        $registerData = [
            'name' => $email,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $loginData = [
            'email' => $email,
            'password' => $password,
        ];
        $response = $this->post(url('/register'), $registerData);
        $response = $this->post(url('/login'), $loginData);
        $response = $this->get(url('/home'));

        $response->assertSee('You are logged in!');
    }
}
//wuallia works, awesome,
//nomally there would need to add more assertions, like if url is proper, because it is default
/// and need to have knowledge where it redirects. if wee write controllers by ourselfs, we know
/// //what sessions, urls expose, what validations are passed and not
/// //