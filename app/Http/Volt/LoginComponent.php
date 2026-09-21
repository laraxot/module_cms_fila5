<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

/**
 * Summary of LoginComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/auth/login.blade.php
 */
class LoginComponent extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function authenticate(): RedirectResponse
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return back();
        }

        $guard = 'web';

        $userClass = XotData::make()->getUserClass();
        $user = $userClass::query()->where('email', $this->email)->first();

        Assert::isInstanceOf($user, UserContract::class);
        $remember = $this->remember;
        event(new Login($guard, $user, $remember));

        return redirect()->intended('/');
    }
}
