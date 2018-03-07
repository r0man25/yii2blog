<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Article */

?>

<h1>Create article</h1>

<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'imageModelUpload' => $imageModelUpload,
        'categories' => $categories,
        'tags' => $tags,
        'selectedTags' => $selectedTags,
    ]) ?>

</div>
