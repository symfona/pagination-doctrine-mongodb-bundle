<?php declare(strict_types=1);

namespace Symfona\DemoBundle\Tests;

use PHPUnit\Framework\TestCase;

final class DemoTest extends TestCase
{
    public function testExample(): void
    {
        self::assertSame(1, 1);
    }
}
