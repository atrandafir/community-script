<?php

namespace common\components;

use Yii;
use \yii\i18n\I18N as BaseI18N;

class I18N extends BaseI18N {
    public function translate($category, $message, $params, $language) {
        
        $prefix=null;
        if (YII_DEBUG && YII_ENV != 'test') {
            $prefix='[L]';
        }
        
        return $prefix.parent::translate($category, $message, $params, $language);
    }
}
