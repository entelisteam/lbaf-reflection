<?php

declare(strict_types=1);

use EntelisTeam\Lbaf\Reflection\Rector\Migration\Migration_20260511_1012_ContainerSplit;
use Rector\Config\RectorConfig;

return Migration_20260511_1012_ContainerSplit::apply(RectorConfig::configure());
