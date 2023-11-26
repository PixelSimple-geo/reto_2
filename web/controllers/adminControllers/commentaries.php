<?php

function adminReadCommentaries(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/commentariesDB.php";
    $commentaries = getAllCommentaries();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminCommentaries.view.php";
}

function adminDeleteCommentary(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/commentariesDB.php";
    $commentaryId = $_GET["commentary_id"];
    try {
        deleteCommentary($commentaryId);
        header("Location: /admin/commentaries/read", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}
