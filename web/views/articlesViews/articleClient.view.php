<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $article['title'] ?? 'Article Details'; ?></title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="contentsContainer">
        <div class="formulario">
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

        <h1>Comentarios</h1>

        <div class="contents">
            <!--TODO los botones de like dislike no van, te redirigen a la seccion review de business-->
            <div>
                <?php if(isset($commentaries)): ?>
                    <?php foreach ($commentaries as $commentary):?>
                    <article id="<?=$commentary["commentaryId"]?>">
                        <?php if(!empty($commentary["creationDate"])): ?>
                        <p><?=$commentary["creationDate"]?></p>
                        <?php elseif(!empty($commentary["modifiedDate"])): ?>
                            <p><?=$commentary["modifiedDate"]?></p>
                        <?php endif; ?>
                        <h2><?=$commentary["title"]?></h2>
                        <p><?=$commentary["description"]?></p>
                        <p>Número de likes: <?=$commentary["likeCount"]?></p>
                        <p>Número de dislike: <?=$commentary["dislikeCount"]?></p>
                        <form action="/likes/crud/add" method="POST">
                            <input type="hidden" name="business_id" value="<?= $article["articleId"] ?>">
                            <input type="hidden" name="review_id" value="<?= $commentary["commentaryId"] ?>">
                            <section data-check>
                                <input type="hidden" name="old_reaction" value="<?=isset($commentary["userFeedback"])?>">
                                <input type="hidden" name="new_reaction" value="">
                                <button type="submit" data-reaction="true"
                                    <?php if ($commentary["userFeedback"]) echo "checked"?>>
                                    Like
                                </button>
                                <button type="submit" data-reaction="false"
                                    <?php if (isset($commentary["userFeedback"]) && !$commentary["userFeedback"])
                                        echo "checked"?>>
                                    Dislike
                                </button>
                            </section>
                        </form>
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
