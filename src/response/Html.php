<?php

declare (strict_types = 1);

namespace SeanPhp\response;

use SeanPhp\Cookie;
use SeanPhp\Response;

/**
 * Html Response
 */
class Html extends Response
{
    /**
     * 输出type
     * @var string
     */
    protected $contentType = 'text/html';

    public function __construct(Cookie $cookie, $data = '', int $code = 200)
    {
        $this->init($data, $code);
        $this->cookie = $cookie;
    }
}
