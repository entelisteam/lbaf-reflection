# entelisteam/php-reflection-helpers

Lightweight PHP reflection utilities. No runtime dependencies beyond the PHP standard library.

## Install

```bash
composer require entelisteam/php-reflection-helpers
```

Requires PHP 8.2 or newer.

## What's inside

### `EntelisTeam\Reflection\TypeCaster`

Converts a scalar value to a PHP type by name. Accepts both PHP type names (`int`, `bool`, `float`, `string`) and legacy `gettype()` names (`integer`, `boolean`, `double`).

```php
use EntelisTeam\Reflection\TypeCaster;

TypeCaster::cast('42', 'int');        // 42
TypeCaster::cast('1', 'bool');        // true
TypeCaster::cast('true', 'bool');     // true (case-insensitive)
TypeCaster::cast(3.14, 'string');     // "3.14"
```

### `EntelisTeam\Reflection\EnumHelper`

Constructs an enum case from a value. Works for both backed enums (`::from()`) and unit enums (constant lookup).

```php
use EntelisTeam\Reflection\EnumHelper;

enum Status: string { case Active = 'active'; case Inactive = 'inactive'; }
EnumHelper::formatEnumValue(Status::class, 'active'); // Status::Active

enum Priority { case Low; case High; }
EnumHelper::formatEnumValue(Priority::class, 'Low');  // Priority::Low
```

For backed enums the value is coerced to the backing type via `TypeCaster::cast()` first, so `'42'` will match an `int`-backed case.

### `EntelisTeam\Reflection\ClassNameHelper`

Returns the short class name (without namespace) with internal caching.

```php
use EntelisTeam\Reflection\ClassNameHelper;

ClassNameHelper::getShortClassName(\App\Foo\Bar::class); // "Bar"
```

### `EntelisTeam\Reflection\MethodParameters`

Cached lookup of method parameters by name.

```php
use EntelisTeam\Reflection\MethodParameters;

$method = new ReflectionMethod(MyController::class, 'handle');

MethodParameters::getReflection($method, 'id');   // ReflectionParameter for $id
MethodParameters::getTypeName($method, 'id');     // "int" (or "mixed" if untyped)
MethodParameters::getList($method);               // ['id' => ReflectionParameter, ...]
```

Throws `\InvalidArgumentException` if the named parameter does not exist.

## License

MIT.
