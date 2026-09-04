<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Livewire\Volt\Component;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Webmozart\Assert\Assert;

/**
 * Summary of VerifyComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/auth/verify.blade.php
 */
class VerifyComponent extends Component
{
    public function resend(): void
    {
        $user = auth()->guard('web')->user();
        Assert::isInstanceOf($user, User::class);

        if ($user->hasVerifiedEmail()) {
            redirect('/');
        }

        $user->sendEmailVerificationNotification();

        if ($user instanceof MustVerifyEmail) {
            event(new Verified($user));
        }

        $this->dispatch('resent');
        session()->flash('resent');
    }
}
