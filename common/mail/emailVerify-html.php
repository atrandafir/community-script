<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p><?php echo Yii::t('front.signup.email', 'Hello {username}', [
                'username'=>$user->username,
            ]); ?>,</p>

    <p><?php echo Yii::t('front.signup.email', 'Follow the link below to verify your email:'); ?></p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
