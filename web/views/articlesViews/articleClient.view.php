<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $article['title'] ?? 'Article Details'; ?></title>
</head>
<body class="structure">

<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

<div class="contentsContainer">
    <h1><?php echo $article['title'] ?? "Sin título"; ?></h1>

    <?php if (!empty($article['description'])): ?>
        <p><?php echo $article['description']; ?></p>
    <?php endif; ?>

    <?php if (!empty($article['creationDate'])): ?>
        <p>Created Date: <?php echo $article['creationDate']; ?></p>
    <?php endif; ?>

    <?php if (!empty($article['modifiedDate'])): ?>
        <p>Modified Date: <?php echo $article['modifiedDate']; ?></p>
    <?php endif; ?>
</div>

<div class="formulario">
    <?php if(isset($userAccount)): ?>
        <form action="/commentaries/crud/add" method="POST">
            <input type="hidden" name="article_id" value="<?=$article["articleId"]?>">
            <label for="title">Title</label>
            <input id="title" name="title" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" minlength="5" maxlength="500" required></textarea>
            <button type="submit">Publicar comentario</button>
        </form>
    <?php else: ?>
        <p>Si inicias sesión puedes publicar comentarios</p>
    <?php endif; ?>
</div>

<div class="contentsContainer">
    <h1>Comentarios</h1>

    <div class="contents">
        <?php if(isset($commentaries)): ?>
            <?php foreach ($commentaries as $commentary):?>
                <div>
                    <article id="<?=$commentary["commentaryId"]?>">
                        <h1><?=htmlspecialchars($commentary["username"])?></h1>
                        <h2><?=htmlspecialchars($commentary["title"])?></h2>
                        <p><?=htmlspecialchars($commentary["description"])?></p>
                        <form action="/commentariesLikes/crud" method="POST" data-form-reaction>
                            <input type="hidden" name="article_id" value="<?= htmlspecialchars($article["articleId"]) ?>">
                            <input type="hidden" name="commentary_id" value="<?= htmlspecialchars($commentary["commentaryId"]) ?>">
                            <section data-check>
                                <input type="hidden" name="old_reaction" value="<?=isset($commentary["userFeedback"])?>">
                                <input type="hidden" name="new_reaction" value="">
                                <?php if(isset($userAccount)): ?>
                                    <button type="button" data-reaction="true"
                                        <?php if (isset($commentary["userFeedback"]) && $commentary["userFeedback"])
                                            echo "checked"?>>
                                        <span><?=$commentary["likeCount"]?></span>
                                        <img src="/statics/media/thumb_up.svg" class="review-icon">
                                    </button>
                                    <button type="button" data-reaction="false"
                                        <?php if (isset($commentary["userFeedback"]) && !$commentary["userFeedback"])
                                            echo "checked"?>>
                                        <span><?=$commentary["dislikeCount"]?></span>
                                        <img src="/statics/media/thumb_down.svg" class="review-icon">
                                    </button>
                                <?php else: ?>
                                    <button type="button"
                                        <?php if (isset($commentary["userFeedback"]) && $commentary["userFeedback"])
                                            echo "checked"?>>
                                        <?=$commentary["likeCount"]?>
                                        <img src="/statics/media/thumb_up.svg" class="review-icon">
                                    </button>
                                    <button type="button"
                                        <?php if (isset($commentary["userFeedback"]) && !$commentary["userFeedback"])
                                            echo "checked"?>>
                                        <?=$commentary["dislikeCount"]?>
                                        <img src="/statics/media/thumb_down.svg" class="review-icon">
                                    </button>
                                <?php endif; ?>
                            </section>
                            <?php if(!empty($commentary["creationDate"])): ?>
                                <p><?=$commentary["creationDate"]?></p>
                            <?php elseif(!empty($commentary["modifiedDate"])): ?>
                                <p><?=$commentary["modifiedDate"]?></p>
                            <?php endif; ?>
                        </form>
                    </article>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
<script>

</script>
</html>