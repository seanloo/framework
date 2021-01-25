<?php

namespace SeanPhp\facade;

if (class_exists('SeanPhp\Facade')) {
    class Facade extends \SeanPhp\Facade
    {}
} else {
    class Facade
    {
        /**
         * 始终创建新的对象实例
         * @var bool
         */
        protected static $alwaysNewInstance;

        protected static $instance;

        /**
         * 获取当前Facade对应类名
         * @access protected
         * @return string
         */
        protected static function getFacadeClass()
        {}

        /**
         * 创建Facade实例
         * @static
         * @access protected
         * @return object
         */
        protected static function createFacade()
        {
            $class = static::getFacadeClass() ?: 'SeanPhp\Template';

            if (static::$alwaysNewInstance) {
                return new $class();
            }

            if (!self::$instance) {
                self::$instance = new $class();
            }

            return self::$instance;

        }

        // 调用实际类的方法
        public static function __callStatic($method, $params)
        {
            return call_user_func_array([static::createFacade(), $method], $params);
        }
    }
}

/**
 * @see \SeanPhp\Template
 * @mixin \SeanPhp\Template
 */
class Template extends Facade
{
    protected static $alwaysNewInstance = true;

    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'SeanPhp\Template';
    }
}
