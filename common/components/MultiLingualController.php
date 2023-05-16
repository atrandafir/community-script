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
        
        // Update last login
        if (!Yii::$app->user->isGuest) {
          Yii::$app->user->identity->updateLastLogin();
        }
        
        parent::init();
    }
    
}
