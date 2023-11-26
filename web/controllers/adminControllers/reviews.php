<?php

function adminReadReviews(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/reviewsDB.php";
    $reviews = getAllReviews();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminReviews.view.php";
}

function adminDeleteReview(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/reviewsDB.php";
    $reviewId = $_GET["review_id"];
    try {
        deleteReview($reviewId);
        header("Location: /admin/reviews/read", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}