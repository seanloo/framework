<?php

declare (strict_types = 1);

namespace frame\facade;

use frame\Facade;
use frame\filesystem\Driver;

/**
 * Class Filesystem
 * @package frame\facade
 * @mixin \frame\Filesystem
 * @method static Driver disk(string $name = null) ,null|string
 * @method static mixed getConfig(null|string $name = null, mixed $default = null) 获取缓存配置
 * @method static array getDiskConfig(string $disk, null $name = null, null $default = null) 获取磁盘配置
 * @method static string|null getDefaultDriver() 默认驱动
 */
class Filesystem extends Facade
{
    protected static function getFacadeClass()
    {
        return 'filesystem';
    }
}
