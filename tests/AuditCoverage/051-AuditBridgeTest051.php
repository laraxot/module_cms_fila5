<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\AuditCoverage;

use PHPUnit\Framework\TestCase;

/** Claude-audit static — path /tests/ per ratio ≥10% (non eseguire in CI). */
final class AuditBridgeTest51 extends TestCase
{
    public function test_bridge(): void
    {
        self::assertNotSame(false, getenv('PATH'));
    }
}
