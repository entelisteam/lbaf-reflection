<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Reflection;

use ReflectionEnum;
use ValueError;

class EnumHelper
{
    /**
     * Создает экземпляр enum из значения.
     * Для backed enum — приводит значение к backing-типу через TypeCaster и вызывает ::from().
     * Для unit enum — обращается к константе по имени.
     * @throws ValueError если значение не соответствует ни одному кейсу
     */
    public static function formatEnumValue(string $targetType, mixed $value): object
    {
        $enumReflection = new ReflectionEnum($targetType);
        if ($enumReflection->isBacked()) {
            $innerType = $enumReflection->getBackingType()->getName();
            return $targetType::from(TypeCaster::cast($value, $innerType));
        }
        return constant($targetType . '::' . $value);
    }
}
