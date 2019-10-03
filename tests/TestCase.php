<?php

namespace Tests;

use App\Role;
use App\User;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createJourney(User $user = null)
    {
        if ($user) {
            return factory('App\Journey')->create([
                'user_id' => $user->id
            ]);
        }

        return factory('App\Journey')->create();
    }

    public function createComment(User $user = null)
    {
        if ($user) {
            return factory('App\Comment')->create([
                'user_id' => $user->id
            ]);
        }

        return factory('App\Comment')->create();
    }

    public function login(User $user = null)
    {
        if ($user) {
            return $this->actingAs($user);
        }

        return $this->actingAs(factory('App\User')->create());
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
        }

        return $this;
    }

    public function createRoles()
    {
        factory(Role::class)->create(['name' => 'moderator']);
        factory(Role::class)->create(['name' => 'admin']);
        factory(Role::class)->create(['name' => 'super_admin']);
    }

    public function createAdmin()
    {
        return factory('App\User')->create()->addRole('admin');
    }

    protected function ignoreCaptcha($name = 'g-recaptcha-response')
    {
        NoCaptcha::shouldReceive('display')
            ->andReturn('<input type="checkbox" value="yes" name="' . $name . '">');
        NoCaptcha::shouldReceive('script')
            ->andReturn('<script src="captcha.js"></script>');
        NoCaptcha::shouldReceive('verify')
            ->andReturn(true);
    }
}
