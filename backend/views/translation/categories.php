<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$title=Yii::t('back.translation', 'Categories for {language}', [
    'language'=>$languageName,
]);

$this->title = $title." - ".Yii::$app->name;

//var_dump($languageName); die();

?>

<h1><?php echo Html::encode($title); ?></h1>

<p>
    <?php echo Html::a(Yii::t('back.translation', 'Back to languages'), ['languages']); ?>
</p>

<p>
    <?php echo Yii::t('back.translation', 'Please choose a category from the list: '); ?>
</p>

<ul>
    <?php foreach ($rows as $row): ?>
    <?php
    $missing=$row['msgCount']-$row['transCount'];
    ?>
    <li>
        <?php echo Html::a($row['category'], ['messages','language'=>$language,'category'=>$row['category']]); ?>
        
        <?php if ($missing): ?>
            <span style="color: red"><?php echo $missing; ?> <?php echo Yii::t('back.translation', 'missing'); ?></span>
        <?php endif; ?>
            
        <span class="text-muted"><?php echo $row['msgCount']; ?> <?php echo Yii::t('back.translation', 'total'); ?></span>
    </li>
    <?php endforeach; ?>
</ul>