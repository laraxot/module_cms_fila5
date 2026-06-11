<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use Modules\Cms\Actions\SaveHeadernavConfigAction;


uses(Modules\Cms\Tests\TestCase::class);
test('SaveHeadernavConfigAction can be instantiated', function () {
    $action = new SaveHeadernavConfigAction();

    Assert::assertInstanceOf(SaveHeadernavConfigAction::class, $action);
});

test('SaveHeadernavConfigAction execute method exists', function () {
    $action = new SaveHeadernavConfigAction();

    });
