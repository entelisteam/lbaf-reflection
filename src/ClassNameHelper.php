<?php
declare(strict_types=1);

namespace EntelisTeam\Reflection;

use ReflectionClass;

class ClassNameHelper
{
    private static array $shortClassNameCache = [];

    /**
     * Возвращает короткое имя класса (без namespace) с кешированием.
     */
    public static function getShortClassName(string $className): string
    {
        return self::$shortClassNameCache[$className] ??= (new ReflectionClass($className))->getShortName();
    }
}
