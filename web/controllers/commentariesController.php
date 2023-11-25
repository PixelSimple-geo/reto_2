<?php

function postCommentaryCrudAdd(): void {
    validateRequiredParameters(["title", "description", "article_id"]);
    require_once $_SERVER["DOCUMENT_ROOT"] . "/models/commentariesDB.php";
    $userAccount = getUserAccountFromSession();
    if (isset($userAccount)) $commentatorId = $userAccount["accountId"];
    else error_401_Unauthorized();
    $articleId = $_POST["article_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    try {
        persistCommentary($commentatorId, $articleId, $title, $description);
        header("Location: /articles/article?articleId=$articleId", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {
        error_500_InternalServerError();
    }
}

function postCommentaryLikeCrudAddEditDelete(): void {
    validateRequiredParameters(["commentary_id", "article_id"]);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/commentariesDB.php";
    $commentaryId = $_POST["commentary_id"];
    $articleId = $_POST["article_id"];
    if (!empty($_POST["new_reaction"])) {
        if ($_POST["new_reaction"] == "true") $isLiked = 2;
        else if ($_POST["new_reaction"] == "false") $isLiked = 1;
    } else $isLiked = 0;
    try {
        $userAccount = getUserAccountFromSession();
        if (!empty($_POST["old_reaction"]) && !empty($_POST["new_reaction"]))
            updateCommentaryLike($userAccount["accountId"], $commentaryId, $isLiked == 2);
        else if (!empty($_POST["new_reaction"]))
            persistCommentaryLike($userAccount["accountId"], $commentaryId, $isLiked == 2);
        else if (!empty($_POST["old_reaction"]))
            deleteCommentaryLike($userAccount["accountId"], $commentaryId);
        header("Location: /articles/article?articleId=$articleId", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {
        error_500_InternalServerError();
    }
}