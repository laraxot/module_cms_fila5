<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt\Password;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

/**
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/auth/password/reset.blade.php
 */
#[Layout('cms::layouts.auth')]
class ResetComponent extends Component
{
    #[Validate('required|email')]
    public ?string $email = null;

    /**
     * Summary of emailSentMessage.
     */
<<<<<<< HEAD
   /** @var array<string, mixed>|bool|string */
=======
    /** @var array<string, mixed>|bool|string */
>>>>>>> laraxot/dev
    public bool|string|array $emailSentMessage = false;

    public function sendResetPasswordLink(): void
    {
        $this->validate();

        $response = Password::broker()->sendResetLink(['email' => $this->email]);

        if (Password::RESET_LINK_SENT === $response) {
            $message = trans($response);
            if (is_array($message)) {
<<<<<<< HEAD
               $this->emailSentMessage = implode(' ', array_map(
=======
                $this->emailSentMessage = implode(' ', array_map(
>>>>>>> laraxot/dev
                    static fn (mixed $item): string => is_scalar($item) ? (string) $item : '',
                    $message
                ));
            } else {
                $this->emailSentMessage = is_string($message) ? $message : (string) $message;
            }

            return;
        }

        $this->addError('email', trans($response));
    }
}
