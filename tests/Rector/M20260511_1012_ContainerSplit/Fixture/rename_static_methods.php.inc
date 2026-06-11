<?php

namespace Tests\Rector\M20260511_1012_HydratorAndContainerSplit\Fixture;

use Lbaf\Reflection\ReflectionHelper;

class UsesReflectionHelper
{
    public function run(\ReflectionMethod $method, mixed $value): array
    {
        $int = ReflectionHelper::mixedToType($value, 'int');
        $param = ReflectionHelper::_getMethodParameterReflection($method, 'name');
        return ReflectionHelper::getMethodParamValuesFromInjection($method, $this->container);
    }
}

?>
-----
<?php

namespace Tests\Rector\M20260511_1012_HydratorAndContainerSplit\Fixture;

use EntelisTeam\Reflection\TypeCaster;
use EntelisTeam\Reflection\MethodParameters;
use Lbaf\Container\InjectionResolver;
class UsesReflectionHelper
{
    public function run(\ReflectionMethod $method, mixed $value): array
    {
        $int = TypeCaster::cast($value, 'int');
        $param = MethodParameters::getReflection($method, 'name');
        return InjectionResolver::resolve($method, $this->container);
    }
}

?>
