<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!empty($comments)):?>

        <table class="table">
            <thead>
            <tr>
                <td>#</td>
                <td>Author</td>
                <td>Text</td>
                <td>Action</td>
            </tr>
            </thead>

            <tbody>
            <?php foreach($comments as $comment):?>
                <tr>
                    <td><?= $comment->id?></td>
                    <td><?= $comment->user->username?></td>
                    <td><?= $comment->text?></td>
                    <td>

                        <ul class="nav navbar-nav text-uppercase">
                            <?php if (!$comment->isAllowed()): ?>
                                <?=
                                    '<li class="btn">'
                                        . Html::beginForm(['','id' => $comment->id])
                                        . Html::input('input','action', 'allow', ['type' => 'hidden'])
                                        . Html::submitButton('Allow',['class' => 'btn btn-success'])
                                        . Html::endForm().
                                    '</li>'
                                ?>
                            <?php else: ?>
                                <?=
                                    '<li class="btn">'
                                        . Html::beginForm(['','id' => $comment->id])
                                        . Html::input('input','action', 'disallow', ['type' => 'hidden'])
                                        . Html::submitButton('Disallow',['class' => 'btn btn-warning'])
                                        . Html::endForm().
                                    '</li>'
                                ?>
                            <?php endif; ?>
                            <?=
                                '<li class="btn">'
                                    . Html::beginForm(['','id' => $comment->id])
                                    . Html::input('input','action', 'delete', ['type' => 'hidden'])
                                    . Html::submitButton('Delete',['class' => 'btn btn-danger'])
                                    . Html::endForm().
                                '</li>'
                            ?>
                        </ul>





                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    <?php endif;?>
</div>