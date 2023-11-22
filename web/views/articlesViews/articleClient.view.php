<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $article['title'] ?? 'Article Details'; ?></title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="contentsContainer">
            <h1><?php echo $article['title'] ?? "Sin título"; ?></h1>

            <?php if (!empty($article['description'])): ?>
                <p>Description: <?php echo $article['description']; ?></p>
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
                    <input type="hidden" name="commentator_id" value="<?=$userAccount["accountId"]?>">
                    <label for="title">Title</label>
                    <input id="title" name="title">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" minlength="5" maxlength="500"></textarea>
                    <button type="submit">Publicar comentario</button>
                </form>
            <?php endif; ?>
        </div>

    <div class="contentsContainer">
        <h1>Comentarios</h1>
 
        <div class="contents">
            <div>
                <?php if(isset($commentaries)): ?>
                    <?php foreach ($commentaries as $commentary):?>
                    <article id="<?=$commentary["commentaryId"]?>">
                        <h2><?=$commentary["title"]?></h2>
                        <p><?=$commentary["description"]?></p>
                        <form action="/commentariesLikes/crud/add" method="POST">
                            <input type="hidden" name="article_id" value="<?= $article["articleId"] ?>">
                            <input type="hidden" name="commentary_id" value="<?= $commentary["commentaryId"] ?>">
                            <section data-check>
                                <input type="hidden" name="old_reaction" value="<?=isset($commentary["userFeedback"])?>">
                                <input type="hidden" name="new_reaction" value="">
                                <button type="submit" data-reaction="true"
                                    <?php if ($commentary["userFeedback"]) echo "checked"?>>
                                    <?=$commentary["likeCount"]?>
                                    <img src="/statics/media/thumb_up.svg" class="review-icon">
                                </button>
                                <button type="submit" data-reaction="false"
                                    <?php if (isset($commentary["userFeedback"]) && !$commentary["userFeedback"])
                                        echo "checked"?>>
                                    <?=$commentary["dislikeCount"]?>
                                    <img src="/statics/media/thumb_down.svg" class="review-icon">
                                </button>
                            </section>
                        </form>
                        <?php if(!empty($commentary["creationDate"])): ?>
                        <p><?=$commentary["creationDate"]?></p>
                        <?php elseif(!empty($commentary["modifiedDate"])): ?>
                            <p><?=$commentary["modifiedDate"]?></p>
                        <?php endif; ?>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
<script>
    document.querySelectorAll("[data-check] button").forEach((element => {
        element.addEventListener("click", (event) => {
            const element = event.target;
            const parent = event.target.parentNode;
            const input = parent.querySelector("input[name='new_reaction']")
            parent.querySelectorAll("button").forEach((element => {
                if (element !== event.target) element.removeAttribute("checked")
            }))
            if (element.hasAttribute("checked")) {
                element.removeAttribute("checked")
                input.value = "";
            } else {
                input.value =  element.getAttribute("data-reaction")
                element.setAttribute("checked", "");
            }
            console.log(input.value);
        });
    }));
</script>
</html>
