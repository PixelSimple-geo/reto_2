<?php

function postReviewCrudAdd(): void {
    validateRequiredParameters(["business_id", "title", "description", "rating"]);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/reviewsDB.php";
    $userAccount = getUserAccountFromSession();
    if (isset($userAccount)) $commentatorId = $userAccount["accountId"];
    else error_401_Unauthorized();
    $businessId = $_POST["business_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $rating = $_POST["rating"];
    try {
        persistBusinessReview($businessId, $userAccount["accountId"], $title, $description, $rating);
        header("Location: /businesses/business?business_id=$businessId", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {
        error_500_InternalServerError();
    }
}

function postReviewLikeCrudAddEditDelete(): void {
    validateRequiredParameters(["review_id", "business_id"]);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/reviewsDB.php";
    $reviewId = $_POST["review_id"];
    $businessId = $_POST["business_id"];
    if (!empty($_POST["new_reaction"])) {
        if ($_POST["new_reaction"] == "true") $isLiked = 2;
        else if ($_POST["new_reaction"] == "false") $isLiked = 1;
    } else $isLiked = 0;
    try {
        $userAccount = getUserAccountFromSession();
        if (!empty($_POST["old_reaction"]) && !empty($_POST["new_reaction"]))
            updateReviewLike($userAccount, $reviewId, $isLiked == 2);
        else if (!empty($_POST["new_reaction"]))
            persistReviewLike($userAccount, $reviewId, $isLiked == 2);
        else if (!empty($_POST["old_reaction"]))
            deleteReviewLike($userAccount, $reviewId);
        header("Location: /businesses/business?business_id=$businessId", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {
        error_500_InternalServerError();
    }
}