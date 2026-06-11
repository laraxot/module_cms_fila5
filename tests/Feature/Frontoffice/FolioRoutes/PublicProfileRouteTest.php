<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('renders the public profile route using the localized profile page', function (): void {
    $user = UserFactory::new()->createOne([
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.test',
        'lang' => 'it',
    ]);

    $userId = $user->getKey();
    Assert::assertNotNull($userId);
    $response = cmsGet('/it/profile/'.(string) $userId);

    $response->assertOk()
        ->assertSee('Mario Rossi')
        ->assertSee(__('pub_theme::profile.badges.public_profile.label'))
        ->assertSee('ProfilePage', false);
});
