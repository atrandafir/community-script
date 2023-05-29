<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">
          <?php echo Html::encode(Yii::t('back.home', 'Welcome to the back office!')); ?>
        </h1>

        <p class="lead">
          <?php echo Html::encode(Yii::t('back.home', 'From here you can manage your Community-Script platform.')); ?>
        </p>

    </div>
  
</div>
