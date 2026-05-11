<?php
declare(strict_types=1);

namespace EntelisTeam\Reflection\Tests\TypeCaster;

use EntelisTeam\Reflection\TypeCaster;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TypeCaster::class)]
final class mixedToTypeTest extends TestCase
{
    public static function provider(): array
    {
        return [
            //bool
            [true, 'bool', true,],
            ['true', 'bool', true,],
            ['TRUE', 'bool', true,],
            ['1', 'bool', true,],
            [1, 'bool', true,],
            [false, 'bool', false,],
            ['false', 'bool', false,],
            ['FALSE', 'bool', false,],
            ['0', 'bool', false,],
            ['', 'bool', false,],
            [0, 'bool', false,],

            //int
            [0, 'int', 0],
            ['0', 'int', 0],
            [100, 'int', 100],
            [100.10, 'int', 100],
            ['100', 'int', 100],
            ['100.10', 'int', 100],
            ['100,10', 'int', 100],
            [false, 'int', 0],
            [true, 'int', 1],

            //string
            [0, 'string', '0'],
            [100, 'string', '100'],
            ['100', 'string', '100'],
            ['true', 'string', 'true'],

            //float
            [0, 'float', 0.0],
            [1.1, 'float', 1.1],
            ['1.1', 'float', 1.1],


        ];
    }

    #[DataProvider('provider')]
    public function testConversion(mixed $data, string $targetType, mixed $expected): void
    {
        $result = TypeCaster::cast($data, $targetType);
        $this->assertSame($expected, $result, sprintf("%s converted to %s must be %s, but %s returned.", $data, $targetType, $expected, $result));
    }

}