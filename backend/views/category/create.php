<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var common\models\Category $model */

$this->title = Yii::t('backend.category', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend.category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
