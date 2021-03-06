<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<!--main content start-->
<div class="main-content">
    <div class="row">
        <div class="col-md-8">
            <?php foreach ($articles as $article): ?>
                <article class="post post-list">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="post-thumb">
                                <a href="blog.html"><img src="<?= $article->getImage() ?>" alt="" class="pull-left"></a>

                                <a href="<?= Url::to(['site/view', 'id' => $article->id]) ?>" class="post-thumb-overlay text-center">
                                    <div class="text-uppercase text-center">View Post</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="post-content">
                                <header class="entry-header text-uppercase">
                                    <h6><?= $article->getCategoryTitle(); ?></h6>

                                    <h1 class="entry-title"><a href="<?= Url::to(['site/view', 'id' => $article->id]) ?>"><?= $article->title ?></a></h1>
                                </header>
                                <div class="entry-content">
                                    <p><?= $article->description ?></p>
                                </div>
                                <div class="social-share">
                                    <span class="social-share-title pull-left text-capitalize">By Rubel On February <?= $article->getDate(); ?></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

            <ul class="pagination">
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
            </ul>
        </div>
        <?=
        $this->render('/partials/sidebar',[
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
            'tags' => $tags,
            'requestId' => $requestId,
            'requestAction' => $requestAction,
        ]);
        ?>
    </div>
</div>
<!-- end main content-->