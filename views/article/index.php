<?php
Use yii\helpers\Url;
?>

<h1>Articles list:</h1>

<a href="<?php echo Url::to(['article/create'])?>" class="btn btn-success">New article</a>
<br><br>

<table class="table table-condensed">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Date</th>
        <th>Category</th>
        <th>Tags</th>
        <th>Image</th>
        <th></th>
        <th></th>
    </tr>

    <?php foreach ($articles as $article): ?>

        <tr>
            <td><?= $article->id ?></td>
            <td><?= $article->title ?></td>
            <td><?= $article->description ?></td>
            <td><?= $article->getDate() ?></td>
            <td><?= $article->getCategoryTitle() ?></td>
            <td><?= $article->getSelectedTagsTitle() ?></td>
            <td><img src="<?= $article->getImage() ?>" alt=""></td>
            <td><a class="btn btn-info" href="<?php echo Url::to(['article/update', 'id' => $article->id])?>">Update</a></td>
            <td><a class="btn btn-danger" href="<?php echo Url::to(['article/delete', 'id' => $article->id])?>">Delete</a></td>
        </tr>

    <?php endforeach; ?>


</table>