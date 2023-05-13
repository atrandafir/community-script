<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = Yii::t('back.translation', 'Translations')." - ".Yii::$app->name;

?>

<p>
    <?php echo Yii::t('back.translation', 'Please choose a language from the list: '); ?>
</p>

<ul>
    <?php foreach (Yii::$app->params['languages'] as $code => $label): ?>
    <li><?php echo Html::a($label, ['categories','language'=>$code]); ?></li>
    <?php endforeach; ?>
</ul>