<?php foreach ($comments as $comment): ?>

    <div class="bottom-comment"><!--bottom comment-->
        <div class="comment-img">
            <img class="img-circle" src="/public/images/comment-img.jpg" alt=""> <!--TODO: Add user photo uploud-->
        </div>

        <div class="comment-text">
            <a href="#" class="replay btn pull-right"> Replay</a>
            <h5><?= $comment->user->username; ?></h5>

            <p class="comment-date">
                <?= $comment->getDate() ?>
            </p>


            <p class="para"><?= $comment->text ?></p>
        </div>
    </div>
    <!-- end bottom comment-->

<?php endforeach; ?>

<?php if (!Yii::$app->user->isGuest): ?>

    <div class="leave-comment"><!--leave comment-->
        <h4>Leave a reply</h4>

        <?php $form = \yii\widgets\ActiveForm::begin([
            'action'=>['site/comment', 'id'=>$article->id],
            'options'=>['class'=>'form-horizontal contact-form', 'role'=>'form']])?>
        <div class="form-group">
            <div class="col-md-12">
                <?= $form->field($commentForm, 'comment')->textarea(['class'=>'form-control','placeholder'=>'Write Message'])->label(false)?>
            </div>
        </div>
        <button type="submit" class="btn send-btn">Post Comment</button>
        <?php \yii\widgets\ActiveForm::end();?>

    </div><!--end leave comment-->
<?php endif; ?>