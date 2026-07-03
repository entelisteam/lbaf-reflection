# entelisteam/lbaf-reflection

Lightweight PHP reflection utilities. No runtime dependencies beyond the PHP standard library.

## Install

```bash
composer require entelisteam/lbaf-reflection
```

Requires PHP 8.2 or newer.

## What's inside

### `EntelisTeam\Lbaf\Reflection\TypeCaster`

Converts a scalar value to a PHP type by name. Accepts both PHP type names (`int`, `bool`, `float`, `string`) and legacy `gettype()` names (`integer`, `boolean`, `double`).

```php
use EntelisTeam\Lbaf\Reflection\TypeCaster;

TypeCaster::cast('42', 'int');        // 42
TypeCaster::cast('1', 'bool');        // true
TypeCaster::cast('true', 'bool');     // true (case-insensitive)
TypeCaster::cast(3.14, 'string');     // "3.14"
```

### `EntelisTeam\Lbaf\Reflection\EnumHelper`

Constructs an enum case from a value. Works for both backed enums (`::from()`) and unit enums (constant lookup).

```php
use EntelisTeam\Lbaf\Reflection\EnumHelper;

enum Status: string { case Active = 'active'; case Inactive = 'inactive'; }
EnumHelper::formatEnumValue(Status::class, 'active'); // Status::Active

enum Priority { case Low; case High; }
EnumHelper::formatEnumValue(Priority::class, 'Low');  // Priority::Low
```

For backed enums the value is coerced to the backing type via `TypeCaster::cast()` first, so `'42'` will match an `int`-backed case.

### `EntelisTeam\Lbaf\Reflection\ClassNameHelper`

Returns the short class name (without namespace) with internal caching.

```php
use EntelisTeam\Lbaf\Reflection\ClassNameHelper;

ClassNameHelper::getShortClassName(\App\Foo\Bar::class); // "Bar"
```

### `EntelisTeam\Lbaf\Reflection\MethodParameters`

Cached lookup of method parameters by name.

```php
use EntelisTeam\Lbaf\Reflection\MethodParameters;

$method = new ReflectionMethod(MyController::class, 'handle');

MethodParameters::getReflection($method, 'id');   // ReflectionParameter for $id
MethodParameters::getTypeName($method, 'id');     // "int" (or "mixed" if untyped)
MethodParameters::getList($method);               // ['id' => ReflectionParameter, ...]
```

Throws `\InvalidArgumentException` if the named parameter does not exist.

## Версионирование

Все пакеты LBAF следуют [SemVer](https://semver.org):

- **Major (`1.x` → `2.0`)** — слом обратной совместимости публичного API. Каждое такое изменение сопровождается Rector-миграцией (см. [lbaf-rector](https://github.com/entelisteam/lbaf-rector)). Обновляется только вручную: поднять constraint в `composer.json` и выполнить `composer update`.
- **Minor (`1.2` → `1.3`)** — новая функциональность, обратная совместимость сохранена.
- **Patch (`1.2.0` → `1.2.1`)** — исправления без изменения публичного API.

Правило: **если изменение требует Rector-миграции — это major**, иначе minor или patch.

Зависимости на пакеты LBAF указываются через caret (`"entelisteam/lbaf-*": "^1.2"`): minor и patch подтягиваются обычным `composer update`, major автоматически не устанавливается. После обновления Rector-миграции применяются автоматически (хук `post-update-cmd`); если хук не настроен — выполните `composer rector:fix`.

## License

MIT.
