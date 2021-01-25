<?php

declare (strict_types = 1);

namespace SeanPhp\facade;

use SeanPhp\Facade;
use SeanPhp\cache\Driver;
use SeanPhp\cache\TagSet;

/**
 * @see \SeanPhp\Cache
 * @package SeanPhp\facade
 * @mixin \SeanPhp\Cache
 * @method static string|null getDefaultDriver() 默认驱动
 * @method static mixed getConfig(null|string $name = null, mixed $default = null) 获取缓存配置
 * @method static array getStoreConfig(string $store, string $name = null, null $default = null) 获取驱动配置
 * @method static Driver store(string $name = null) 连接或者切换缓存
 * @method static bool clear() 清空缓冲池
 * @method static mixed get(string $key, mixed $default = null) 读取缓存
 * @method static bool set(string $key, mixed $value, int|\DateTime $ttl = null) 写入缓存
 * @method static bool delete(string $key) 删除缓存
 * @method static iterable getMultiple(iterable $keys, mixed $default = null) 读取缓存
 * @method static bool setMultiple(iterable $values, null|int|\DateInterval $ttl = null) 写入缓存
 * @method static bool deleteMultiple(iterable $keys) 删除缓存
 * @method static bool has(string $key) 判断缓存是否存在
 * @method static TagSet tag(string|array $name) 缓存标签
 */
class Cache extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'cache';
    }

    /**
     * 自增缓存（针对数值缓存）
     * @access public
     * @param string $name 缓存变量名
     * @param int $step 步长
     * @return false|int
     */
    public function inc(string $name, int $step = 1)
    {
        // TODO: Implement inc() method.
    }

    /**
     * 自减缓存（针对数值缓存）
     * @access public
     * @param string $name 缓存变量名
     * @param int $step 步长
     * @return false|int
     */
    public function dec(string $name, int $step = 1)
    {
        // TODO: Implement dec() method.
    }

    /**
     * 删除缓存标签
     * @access public
     * @param array $keys 缓存标识列表
     * @return void
     */
    public function clearTag(array $keys)
    {
        // TODO: Implement clearTag() method.
    }
}
