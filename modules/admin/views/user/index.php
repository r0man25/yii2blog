<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
//            'status',
            [
                'format' => 'html',
                'label' => 'created_at',
                'value' => function($data){
                    return $data->getDate($data->created_at);
                }
            ],
            [
                'format' => 'html',
                'label' => 'updated_at',
                'value' => function($data){
                    return $data->getDate($data->updated_at);
                }
            ],
            [
                'format' => 'html',
                'label' => 'Is admin',
                'value' => function($data){
                    return $data->getUserAdminStatus();
                }
            ],
            [
                'format' => 'html',
                'label' => 'Role',
                'value' => function($data){
                    return ($data->getRoleTitle()) ? $data->getRoleTitle() : '';
                }
            ],
            'photo',
            [
                'format' => 'html',
                'label' => 'Image',
                'value' => function($data){
                    return Html::img($data->getImage(), ['width' => 80]);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
