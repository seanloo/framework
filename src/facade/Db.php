<?php

namespace frame\facade;

if (class_exists('frame\Facade')) {
    class Facade extends \frame\Facade
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
         * @param  bool $newInstance 是否每次创建新的实例
         * @return object
         */
        protected static function createFacade(bool $newInstance = false)
        {
            $class = static::getFacadeClass() ?: 'frame\DbManager';

            if (static::$alwaysNewInstance) {
                $newInstance = true;
            }

            if ($newInstance) {
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
 * @see \frame\DbManager
 * @mixin \frame\DbManager
 */
class Db extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'frame\DbManager';
    }
}
