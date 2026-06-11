<?php

declare(strict_types=1);

namespace EntelisTeam\Lbaf\Reflection\Rector;

use EntelisTeam\Lbaf\Reflection\Rector\Migration\Migration_20260511_1012_ContainerSplit;
use EntelisTeam\Lbaf\Reflection\Rector\Migration\Migration_20260611_0811_ReflectionNamespaceToLbaf;
use EntelisTeam\Lbaf\Rector\RectorMigrationListInterface;

/**
 * Реестр Rector-миграций пакета.
 *
 * Регистрируется через composer.json `extra.lbaf-rector-migrations`;
 * автоматически подхватывается Manager-ом.
 */
final class MigrationList implements RectorMigrationListInterface
{
    /**
     * @return list<class-string>
     */
    public static function all(): array
    {
        return [
            Migration_20260511_1012_ContainerSplit::class,
            Migration_20260611_0811_ReflectionNamespaceToLbaf::class,
        ];
    }
}
