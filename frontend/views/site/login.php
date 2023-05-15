<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('front.login', 'Log in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">
          
            <p>
                <?php echo Yii::t('front.login', 'Don\'t have an user account yet? {linkStart}Sign up here{linkEnd}', [
                    'linkStart'=>'<a href="'.Url::to(['site/signup']).'" class="btn btn-secondary btn-sm">',
                    'linkEnd'=>'</a>',
                ]); ?>
            </p>
          
            <?php $form = ActiveForm::begin([
                  'id' => 'login-form',
                  'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="my-1 mx-0" style="color:#999;">
                    <?php echo Yii::t('front.login', 'If you forgot your password you can {linkStart}reset it{linkEnd}', [
                        'linkStart'=>'<a href="'.Url::to(['site/request-password-reset']).'">',
                        'linkEnd'=>'</a>',
                    ]); ?>
                    <br>
                    <?php echo Yii::t('front.login', 'Need new verification email? {linkStart}Resend{linkEnd}', [
                        'linkStart'=>'<a href="'.Url::to(['site/resend-verification-email']).'">',
                        'linkEnd'=>'</a>',
                    ]); ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('front.login', 'Log in'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
