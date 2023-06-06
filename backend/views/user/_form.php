<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
                 'enableClientValidation' => false,
               ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo_approved')->checkbox() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'admin')->textInput() ?>
  
    <?php if (empty($model->id)): ?>
      <?= $form->field($model, 'new_password')->passwordInput()->hint(Yii::t('backend.user', 'Please enter a password for the user.')) ?>
    <?php else: ?>
      <?= $form->field($model, 'new_password')->passwordInput()->hint(Yii::t('backend.user', 'Fill only if you want to change the user\'s password.')) ?>
    <?php endif; ?>

    <div>
        <?= Html::submitButton(Yii::t('backend.user', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
