<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'status',
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
            [
                'format' => 'html',
                'label' => 'photo',
                'value' => function($data){
                    return Html::tag('p',$data->photo) . Html::img($data->getImage(), ['width' => 200]);
                }
            ],
        ],
    ]) ?>

</div>
