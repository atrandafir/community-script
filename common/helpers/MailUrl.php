<?php

namespace common\helpers;

use Yii;

// todo: implement in future mails between applications

class MailUrl {

  static public function generateBackendUrl($params) {
    $urlManagerComponentName = 'urlManager';
    if (in_array(Yii::$app->id, ['app-frontend', 'app-console'])) {
      $urlManagerComponentName = 'urlManagerBackend';
    }
    $url = Yii::$app->{$urlManagerComponentName}->createAbsoluteUrl($params);
    return $url;
  }

  static public function generateFrontendUrl($params) {
    $urlManagerComponentName = 'urlManager';
    if (in_array(Yii::$app->id, ['app-backend', 'app-console'])) {
      $urlManagerComponentName = 'urlManagerFrontend';
    }
    $url = Yii::$app->{$urlManagerComponentName}->createAbsoluteUrl($params);
    return $url;
  }

}
