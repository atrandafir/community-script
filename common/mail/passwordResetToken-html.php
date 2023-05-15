<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?php echo Yii::t('front.passwordReset', 'Hello {username}', [
                'username'=>$user->username,
            ]); ?>,</p>

    <p><?php echo Yii::t('front.passwordReset', 'Follow the link below to reset your password:'); ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
