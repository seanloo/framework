<?php

declare (strict_types = 1);

namespace SeanPhp\service;

use SeanPhp\Service;
use SeanPhp\Validate;

/**
 * 验证服务类
 */
class ValidateService extends Service
{
    public function boot()
    {
        Validate::maker(function (Validate $validate) {
            $validate->setLang($this->app->lang);
            $validate->setDb($this->app->db);
            $validate->setRequest($this->app->request);
        });
    }
}
