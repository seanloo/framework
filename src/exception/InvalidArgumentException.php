<?php

declare (strict_types = 1);
namespace SeanPhp\exception;

use Psr\Cache\InvalidArgumentException as Psr6CacheInvalidArgumentInterface;
use Psr\SimpleCache\InvalidArgumentException as SimpleCacheInvalidArgumentInterface;

/**
 * 非法数据异常
 */
class InvalidArgumentException extends \InvalidArgumentException implements Psr6CacheInvalidArgumentInterface, SimpleCacheInvalidArgumentInterface
{
}
