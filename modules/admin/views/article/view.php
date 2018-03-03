<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $imageUploadModel app\models\image\ImageUpload */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Set tags', ['set-tags', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
<!--   +++++++++++++++++++++       Insert IMAGE    +++++++++++++++++++++         -->
        <!--         Html::a('Add image', ['set-image', 'id' => $model->id], ['class' => 'btn btn-default']) -->
        <div class="btn btn-info">
            <?php $form = ActiveForm::begin(['action' => ['set-image','id' => $model->id]]); ?>
                <?= $form->field($imageUploadModel, 'image')->fileInput(['maxlength' => true]) ?>
                <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end(); ?>
        </div>
<!--   +++++++++++++++++++++       Insert IMAGE    +++++++++++++++++++++         -->


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'content:ntext',
            'date',
            [
                'format' => 'html',
                'label' => 'Category',
                'value' => function($data){
                    return ($data->category) ? $data->category->title : "";
                }
            ],
            [
                'format' => 'html',
                'label' => 'Tags',
                'value' => function($data) {
                    if ($data->tags) {
                        $arrTags = ArrayHelper::getColumn($data->tags, 'title');
                        $strTags = implode('; ', $arrTags);
                        return $strTags;
                    }
                }
            ],
            [
                'format' => 'html',
                'label' => 'Image',
                'value' => function($data){
                    return Html::tag('p',$data->image) . Html::img($data->getImage(), ['width' => 200]);
                }
            ],
            [
                'format' => 'html',
                'label' => 'User',
                'value' => function($data){
                    return $data->getUsername();
                }
            ],
        ],
    ]) ?>

</div>
