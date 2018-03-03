<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
//            'content:ntext',
            'date',
            [
                'format' => 'html',
                'label' => 'Category',
                'value' => function($data){
                    return ($data->category) ? $data->category->title : '';
                }
            ],
            [
                'format' => 'html',
                'label' => 'Tags',
                'value' => function($data){
                    if ($data->tags){
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
                    return Html::img($data->getImage(), ['width' => 200]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'options' => [
                        'class' => 'col-md-1'
                ]
            ],

            [
                'format' => 'html',
                'label' => 'User',
                'value' => function($data){
                    return $data->getUsername();
                }
            ],
        ],
    ]); ?>
</div>
