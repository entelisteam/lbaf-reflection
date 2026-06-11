<?php

declare(strict_types=1);

namespace EntelisTeam\Lbaf\Reflection\Rector\Migration;

use Rector\Configuration\RectorConfigBuilder;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\RenameStaticMethod;

/**
 * Миграция для downstream-проектов: переход с Lbaf-овских namespace'ов на
 * entelisteam/php-reflection-helpers, entelisteam/php-hydrator и Lbaf\Container\InjectionResolver.
 *
 * Подхватывается автоматически через lbaf-rector (extra.lbaf-rector-migrations).
 *
 * Покрывает переименования классов и статических методов. Use-импорты и FQN
 * обновляются автоматически встроенными RenameClassRector и RenameStaticMethodRector.
 */
final class Migration_20260511_1012_ContainerSplit
{
    /**
     * Карта переименований классов: old FQN → new FQN.
     */
    public const CLASS_RENAMES = [
        // Reflection utilities
        'Lbaf\\Reflection\\EnumHelper' => 'EntelisTeam\\Reflection\\EnumHelper',
    ];

    /**
     * @return RenameStaticMethod[]
     */
    public static function getStaticMethodRenames(): array
    {
        return [
            // Reflection utilities
            new RenameStaticMethod('Lbaf\\Reflection\\ReflectionHelper', 'mixedToType', 'EntelisTeam\\Reflection\\TypeCaster', 'cast'),
            new RenameStaticMethod('Lbaf\\Reflection\\ReflectionHelper', '_getMethodParameterReflection', 'EntelisTeam\\Reflection\\MethodParameters', 'getReflection'),

            // Container DI resolver
            new RenameStaticMethod('Lbaf\\Reflection\\ReflectionHelper', 'getMethodParamValuesFromInjection', 'Lbaf\\Container\\InjectionResolver', 'resolve'),
        ];
    }

    /**
     * Применяет правила миграции к существующему конфигуратору.
     */
    public static function apply(RectorConfigBuilder $config): RectorConfigBuilder
    {
        return $config
            ->withConfiguredRule(RenameClassRector::class, self::CLASS_RENAMES)
            ->withConfiguredRule(RenameStaticMethodRector::class, self::getStaticMethodRenames())
            //импортируем короткие имена через use вместо FQN, удаляем устаревшие use на Lbaf-овские классы
            ->withImportNames(importNames: true, importDocBlockNames: true, importShortClasses: false, removeUnusedImports: true);
    }
}
