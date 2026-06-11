<?php

declare(strict_types=1);

namespace EntelisTeam\Lbaf\Reflection\Rector\Migration;

use Rector\Configuration\RectorConfigBuilder;
use Rector\Renaming\Rector\Name\RenameClassRector;

/**
 * Миграция для downstream-проектов: переход пакета entelisteam/php-reflection-helpers
 * на новое имя entelisteam/lbaf-reflection с базовым namespace EntelisTeam\Lbaf\Reflection.
 *
 * Подхватывается автоматически через lbaf-rector (extra.lbaf-rector-migrations).
 */
final class Migration_20260611_0811_ReflectionNamespaceToLbaf
{
    /**
     * Карта переименований классов: old FQN → new FQN.
     */
    public const CLASS_RENAMES = [
        'EntelisTeam\\Reflection\\ClassNameHelper' => 'EntelisTeam\\Lbaf\\Reflection\\ClassNameHelper',
        'EntelisTeam\\Reflection\\EnumHelper' => 'EntelisTeam\\Lbaf\\Reflection\\EnumHelper',
        'EntelisTeam\\Reflection\\MethodParameters' => 'EntelisTeam\\Lbaf\\Reflection\\MethodParameters',
        'EntelisTeam\\Reflection\\TypeCaster' => 'EntelisTeam\\Lbaf\\Reflection\\TypeCaster',
    ];

    /**
     * Применяет правила миграции к существующему конфигуратору.
     */
    public static function apply(RectorConfigBuilder $config): RectorConfigBuilder
    {
        return $config
            ->withConfiguredRule(RenameClassRector::class, self::CLASS_RENAMES);
    }
}
