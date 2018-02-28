<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

<!--Html::dropDownList('tags', $selectedTags, $tags, ['class' => 'form-control', 'multiple' => true])-->
    <?= Html::checkboxList('tags', $selectedTags, $tags) ?>

    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
