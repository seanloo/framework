<?php

declare (strict_types = 1);

namespace frame\facade;

use frame\Facade;

/**
 * @see \frame\Cookie
 * @package frame\facade
 * @mixin \frame\Cookie
 * @method static mixed get(mixed $name = '', string $default = null) 获取cookie
 * @method static bool has(string $name) 是否存在Cookie参数
 * @method static void set(string $name, string $value, mixed $option = null) Cookie 设置
 * @method static void forever(string $name, string $value = '', mixed $option = null) 永久保存Cookie数据
 * @method static void delete(string $name) Cookie删除
 * @method static array getCookie() 获取cookie保存数据
 * @method static void save() 保存Cookie
 */
class Cookie extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'cookie';
    }
}
