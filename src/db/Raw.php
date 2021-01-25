<?php

declare (strict_types = 1);

namespace SeanPhp\db;

/**
 * SQL Raw
 */
class Raw
{
    /**
     * 查询表达式
     *
     * @var string
     */
    protected $value;

    /**
     * 创建一个查询表达式
     *
     * @param  string  $value
     * @return void
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * 获取表达式
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
