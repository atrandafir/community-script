<?php

namespace common\components;

use Yii;
use yii\web\UrlManager;

class MultiLingualUrlManager extends UrlManager {
    public function createUrl($params): string {
        
        $params['lang'] = isset($params['lang']) ? $params['lang'] : Yii::$app->language;
        
        if ($params['lang']==\Yii::$app->params['language']) {
          unset($params['lang']);
        }
        
        return parent::createUrl($params);
    }
}
