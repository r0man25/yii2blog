<?php
use yii\helpers\Url;
use app\widgets\Alert;
?>

<!--main content start-->
<div class="main-content">
    <?= Alert::widget() ?>
    <div class="row">
        <div class="col-md-8">
            <article class="post">
                <div class="post-thumb">
                    <img src="<?= $article->getImage() ?>" alt="">
                </div>
                <div class="post-content">
                    <header class="entry-header text-center text-uppercase">
                        <h6><a href="<?= Url::to(['site/category', 'id' => $article->category_id]) ?>"> <?= $article->getCategoryTitle() ?></a></h6>

                        <h1 class="entry-title"><?= $article->title ?></h1>


                    </header>
                    <div class="entry-content">

                        <p><?= $article->content ?></p>

                    </div>
                    <div class="decoration">
                        <?php foreach ($selectedTags as $tag): ?>
                            <a href="<?= Url::to(['site/tag', 'id' => $tag->id]) ?>" class="btn btn-default"><?= $tag->title ?></a>
                        <?php endforeach; ?>
                    </div>

                </div>
            </article>
            <div class="row"><!--blog next previous-->
                <?php if ($prevArticle): ?>
                    <div class="col-md-6">
                        <div class="single-blog-box">
                            <a href="<?= Url::to(['site/view', 'id' => $prevArticle->id]) ?>">
                                <img src="<?= $prevArticle->getImage() ?>" alt="">

                                <div class="overlay">

                                    <div class="promo-text">
                                        <p><i class=" pull-left fa fa-angle-left"></i></p>
                                        <h5><?= $prevArticle->title ?></h5>
                                    </div>
                                </div>


                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($nextArticle): ?>
                    <div class="col-md-6">
                        <div class="single-blog-box">
                            <a href="<?= Url::to(['site/view', 'id' => $nextArticle->id]) ?>">
                                <img src="<?= $nextArticle->getImage() ?>" alt="">

                                <div class="overlay">
                                    <div class="promo-text">
                                        <p><i class=" pull-right fa fa-angle-right"></i></p>
                                        <h5><?= $nextArticle->title ?></h5>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div><!--blog next previous end-->
            <div class="related-post-carousel"><!--related post carousel-->
                <div class="related-heading">
                    <h4>You might also like</h4>
                </div>
                <div class="items">

                    <?php foreach ($categoryArticles as $article): ?>

                        <div class="single-item">
                            <a href="<?= Url::to(['site/view', 'id' => $article->id]) ?>">
                                <img width="220" src="<?= $article->getImage() ?>" alt="">

                                <p><?= $article->title ?></p>
                            </a>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div><!--related post carousel-->



            <?= $this->render('/partials/comment', [
                    'article' => $article,
                    'comments' => $comments,
                    'commentForm' => $commentForm,
            ]) ?>

        </div>

            <?= $this->render('/partials/sidebar',[
                    'popular' => $popular,
                    'recent' => $recent,
                    'categories' => $categories,
                    'tags' => $tags,
                ]);?>
         </div>
</div>
<!-- end main content-->