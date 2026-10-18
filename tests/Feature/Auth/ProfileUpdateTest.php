<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class);

    $user = $userClass::factory()->create();

    $lang = app()->getLocale();
    actingAs($user)->get('/'.$lang.'/settings/profile')->assertOk();
});

    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)
        ->toBe('Test User')
        ->and($user->email)
        ->toBe('test@example.com')
        ->and($user->email_verified_at)
        ->toBeNull();
});

    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('settings.delete-user-form')->set('password', 'password')->call('deleteUser');

    $response->assertHasNoErrors()->assertRedirect('/');

    expect($user->fresh())->toBeNull()->and(auth()->check())->toBeFalse();
});

    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('settings.delete-user-form')->set('password', 'wrong-password')->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});
