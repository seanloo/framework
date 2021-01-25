<?php

declare (strict_types = 1);

namespace SeanPhp\facade;

use SeanPhp\Facade;

/**
 * @see \SeanPhp\View
 * @package SeanPhp\facade
 * @mixin \SeanPhp\View
 * @method static \SeanPhp\View engine(string $type = null) 获取模板引擎
 * @method static \SeanPhp\View assign(string|array $name, mixed $value = null) 模板变量赋值
 * @method static \SeanPhp\View filter(\SeanPhp\Callable $filter = null) 视图过滤
 * @method static string fetch(string $template = '', array $vars = []) 解析和获取模板内容 用于输出
 * @method static string display(string $content, array $vars = []) 渲染内容输出
 * @method static mixed __set(string $name, mixed $value) 模板变量赋值
 * @method static mixed __get(string $name) 取得模板显示变量的值
 * @method static bool __isset(string $name) 检测模板变量是否设置
 * @method static string|null getDefaultDriver() 默认驱动
 */
class View extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'view';
    }
}
