<?php

declare (strict_types=1);

namespace SeanPhp\route\dispatch;

use SeanPhp\exception\HttpException;
use SeanPhp\helper\Str;
use SeanPhp\Request;
use SeanPhp\route\Rule;

/**
 * Url Dispatcher
 */
class Url extends Controller
{

    public function __construct(Request $request, Rule $rule, $dispatch)
    {
        $this->request = $request;
        $this->rule = $rule;
        // 解析默认的URL规则
        $dispatch = $this->parseUrl($dispatch);

        parent::__construct($request, $rule, $dispatch, $this->param);
    }

    /**
     * 解析URL地址
     * @access protected
     * @param  string $url URL
     * @return array
     */
    protected function parseUrl(string $url): array
    {
        $pathInfoType = $this->request->pathInfoType();
        $depr = $this->rule->config('pathinfo_depr');
        $bind = $this->rule->getRouter()->getDomainBind();

        if ($bind && preg_match('/^[a-z]/is', $bind)) {
            $bind = str_replace('/', $depr, $bind);
            // 如果有域名绑定
            $url = $bind . ('.' != substr($bind, -1) ? $depr : '') . ltrim($url, $depr);
        }

        $path = $this->rule->parseUrlPath($url);
        if (empty($path)) {
            return [null, null, null];
        }

        // 解析模块
        $module = !empty($path) ? array_shift($path) : null;

        // 解析控制器
        $controller = !empty($path) ? array_shift($path) : null;

        if ($controller && !preg_match('/^[A-Za-z0-9][\w|\.]*$/', $controller)) {
            throw new HttpException(404, 'controller not exists:' . $controller);
        }

        // 解析操作
        if ($pathInfoType == '1') {
            $action = !empty($path) ? implode($depr, $path) : null;
        } else {
            $action = !empty($path) ? array_shift($path) : null;
        }

        // 解析额外参数
        $var = [];
        if ($path && $pathInfoType == '0') {
            preg_replace_callback('/(\w+)\|([^\|]+)/', function ($match) use (&$var) {
                $var[$match[1]] = strip_tags($match[2]);
            }, implode('|', $path));
        }

        $panDomain = $this->request->panDomain();
        if ($panDomain && $key = array_search('*', $var)) {
            // 泛域名赋值
            $var[$key] = $panDomain;
        }

        // 设置当前请求的参数
        $this->param = $var;

        // 封装路由
        $route = [$module, $controller, $action];

        if ($this->hasDefinedRoute($route)) {
            throw new HttpException(404, 'invalid request:' . str_replace('|', $depr, $url));
        }

        return $route;
    }

    /**
     * 检查URL是否已经定义过路由
     * @access protected
     * @param  array $route 路由信息
     * @return bool
     */
    protected function hasDefinedRoute(array $route): bool
    {
        [$module, $controller, $action] = $route;

        $module = $module ? Str::studly($module) : '';
        $controller = $controller ? Str::studly($controller) : '';

        // 检查地址是否被定义过路由
        $name = strtolower($module . '/' . $controller . '/' . $action);

        $host = $this->request->host(true);
        $method = $this->request->method();

        if ($this->rule->getRouter()->getName($name, $host, $method)) {
            return true;
        }

        return false;
    }

}
