<?php

function postReviewCrudAdd(): void {
    validateRequiredParameters(["business_id", "title", "description", "rating"]);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/reviewsDB.php";
    $businessId = $_POST["business_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $rating = $_POST["rating"];
    try {
        $userAccount = getUserAccountFromSession();
        persistBusinessReview($businessId, $userAccount["accountId"], $title, $description, $rating);
        header("Location: /businesses/business?business_id=$businessId", true, 303);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    } catch (RuntimeException $exception) {
        echo $exception->getMessage();
    }
}

function postReviewLikeCrudAdd(): void {
    validateRequiredParameters(["review_id", "business_id"]);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/reviewsDB.php";
    $reviewId = $_POST["review_id"];
    if (isset($_POST["is_liked"]) && $_POST["is_liked"] == "on")
        $isLiked = true;
    else $isLiked = false;
    $businessId = $_POST["business_id"];
    try {
        $userAccount = getUserAccountFromSession();
        persistReviewLike($userAccount["accountId"], $reviewId, $isLiked);
        header("Location: /businesses/business?business_id=$businessId", true, 303);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    } catch (RuntimeException $exception) {
        echo $exception->getMessage();
    }
}