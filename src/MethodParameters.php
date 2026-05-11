<?php
declare(strict_types=1);

namespace EntelisTeam\Reflection;

use InvalidArgumentException;
use ReflectionMethod;
use ReflectionParameter;

class MethodParameters
{
    /**
     * Кеш массива ReflectionParameter[] по имени параметра, индексированный classFQN -> methodName.
     */
    private static array $classMethodCache = [];

    /**
     * Возвращает ReflectionParameter по имени.
     * @throws InvalidArgumentException если параметра с таким именем нет
     */
    public static function getReflection(ReflectionMethod $reflectionMethod, string $parameterName): ReflectionParameter
    {
        $methodParams = self::getList($reflectionMethod);
        if (!isset($methodParams[$parameterName])) {
            throw new InvalidArgumentException(
                'Parameter "' . $parameterName . '" not found in ' . $reflectionMethod->class . '::' . $reflectionMethod->getName()
            );
        }
        return $methodParams[$parameterName];
    }

    /**
     * Возвращает имя типа параметра по имени параметра. 'mixed' если тип не указан.
     */
    public static function getTypeName(ReflectionMethod $reflectionMethod, string $parameterName): string
    {
        return self::getReflection($reflectionMethod, $parameterName)->getType()?->getName() ?? 'mixed';
    }

    /**
     * @return array<string, ReflectionParameter> параметры метода, индексированные по имени, с кешированием
     */
    public static function getList(ReflectionMethod $reflectionMethod): array
    {
        $class = $reflectionMethod->class;
        $name = $reflectionMethod->getName();
        if (!isset(self::$classMethodCache[$class][$name])) {
            $result = [];
            foreach ($reflectionMethod->getParameters() as $param) {
                $result[$param->getName()] = $param;
            }
            self::$classMethodCache[$class][$name] = $result;
        }
        return self::$classMethodCache[$class][$name];
    }
}
