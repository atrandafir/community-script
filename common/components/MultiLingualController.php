<?php

namespace common\components;

use Yii;
use yii\web\Controller;

class MultiLingualController extends Controller {
    
    public function init()
    {
        $languageGet = isset($_GET['lang']) ? $_GET['lang'] : null;
        if ($languageGet) {
            Yii::$app->language = $languageGet;
        }
        parent::init();
    }
    
}
