<?php
use yii\helpers\Url;
?>

<!--main content start-->
<div class="main-content">
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
                    <!--++++++++++++++++++++++++++++++++++++++   TAGS   ++++++++++++++++++++++++++++++++++++++-->
                    <div class="decoration">
                        <?php foreach ($selectedTags as $tag): ?>
                            <a href="<?= Url::to(['site/tag', 'id' => $tag->id]) ?>" class="btn btn-default"><?= $tag->title ?></a>
                        <?php endforeach; ?>
                    </div>

                </div>
            </article>
            <!--top comment-->
            <!--                <div class="top-comment">-->
            <!--                    <img src="/public/images/comment.jpg" class="pull-left img-circle" alt="">-->
            <!--                    <h4>Rubel Miah</h4>-->
            <!---->
            <!--                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy hello ro mod tempor-->
            <!--                        invidunt ut labore et dolore magna aliquyam erat.</p>-->
            <!--                </div>-->
            <!--top comment end-->
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
            <div class="bottom-comment"><!--bottom comment-->
                <h4>3 comments</h4>

                <div class="comment-img">
                    <img class="img-circle" src="/public/images/comment-img.jpg" alt="">
                </div>

                <div class="comment-text">
                    <a href="#" class="replay btn pull-right"> Replay</a>
                    <h5>Rubel Miah</h5>

                    <p class="comment-date">
                        December, 02, 2015 at 5:57 PM
                    </p>


                    <p class="para">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                        diam nonumy
                        eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                        voluptua. At vero eos et cusam et justo duo dolores et ea rebum.</p>
                </div>
            </div>
            <!-- end bottom comment-->


            <div class="leave-comment"><!--leave comment-->
                <h4>Leave a reply</h4>


                <form class="form-horizontal contact-form" role="form" method="post" action="#">

                    <div class="form-group">
                        <div class="col-md-12">
										<textarea class="form-control" rows="6" name="message"
                                                  placeholder="Write Massage"></textarea>
                        </div>
                    </div>
                    <a href="#" class="btn send-btn">Post Comment</a>
                </form>
            </div><!--end leave comment-->
        </div>

            <?=
                $this->render('/partials/sidebar',[
                    'popular' => $popular,
                    'recent' => $recent,
                    'categories' => $categories,
                    'tags' => $tags,
                ]);
            ?>
         </div>
</div>
<!-- end main content-->