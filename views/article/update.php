<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

?>
<div class="article-update">

    <h1>Update Article: <?= $model->title ?></h1>

    <?php echo Html::img($model->getImage(), ['width' => 200]); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'imageModelUpload' => $imageModelUpload,
        'categories' => $categories,
        'tags' => $tags,
        'selectedTags' => $selectedTags,
    ]) ?>

</div>
