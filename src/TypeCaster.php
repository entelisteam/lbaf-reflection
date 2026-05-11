<?php
declare(strict_types=1);

namespace EntelisTeam\Reflection;

class TypeCaster
{
    /**
     * Конвертирует значение в указанный тип.
     * Поддерживает PHP-имена типов (int, bool, float, string) и legacy-имена от gettype() (integer, boolean, double).
     */
    public static function cast(mixed $data, string $type): mixed
    {
        return match ($type) {
            'boolean', 'bool' => ((is_string($data) && strtolower($data) === 'true') || $data === '1' || $data === true || $data === 1),
            'integer', 'int' => (int)$data,
            'double', 'float' => (float)$data,
            'string' => (string)$data,
            default => $data,
        };
    }
}
