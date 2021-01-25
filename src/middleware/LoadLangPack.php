<?php

declare (strict_types = 1);

namespace SeanPhp\middleware;

use Closure;
use SeanPhp\App;
use SeanPhp\Lang;
use SeanPhp\Request;
use SeanPhp\Response;

/**
 * 多语言加载
 */
class LoadLangPack
{
    protected $app;

    protected $lang;

    public function __construct(App $app, Lang $lang)
    {
        $this->app  = $app;
        $this->lang = $lang;
    }

    /**
     * 路由初始化（路由规则注册）
     * @access public
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        // 自动侦测当前语言
        $langset = $this->lang->detect($request);

        if ($this->lang->defaultLangSet() != $langset) {
            // 加载系统语言包
            $this->lang->load([
                $this->app->getframePath() . 'lang' . DIRECTORY_SEPARATOR . $langset . '.php',
            ]);

            $this->app->LoadLangPack($langset);
        }

        $this->lang->saveToCookie($this->app->cookie);

        return $next($request);
    }
}
