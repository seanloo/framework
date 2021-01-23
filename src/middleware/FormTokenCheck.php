<?php

declare (strict_types = 1);

namespace frame\middleware;

use Closure;
use frame\exception\ValidateException;
use frame\Request;
use frame\Response;

/**
 * 表单令牌支持
 */
class FormTokenCheck
{

    /**
     * 表单令牌检测
     * @access public
     * @param Request $request
     * @param Closure $next
     * @param string  $token 表单令牌Token名称
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $token = null)
    {
        $check = $request->checkToken($token ?: '__token__');

        if (false === $check) {
            throw new ValidateException('invalid token');
        }

        return $next($request);
    }

}
