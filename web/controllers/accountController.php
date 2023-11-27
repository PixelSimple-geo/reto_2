<?php

function getLogin(): void {
    if (isUserAccountInSession()) header("Location: /index", true, 303);
    else include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
}

function postLogin(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    validateRequiredParameters(["username", "password"]);
    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
        $userAccount = getAccountByUsername($username);
        if (password_verify($password, $userAccount["password"])) {
            startSession();
            addUserAccountToSession($userAccount);
            header("Location: /index", true, 303);
        } else {
            $errorMessage = "La contraseña no es válida";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
        }
    } catch (Exception $exception) {
        if (str_contains($exception->getMessage(), "no row was affected")) {
            $errorMessage = "Usuario no encontrado";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
            die();
        }
        error_500_InternalServerError();
    }
}

function getSignIn(): void {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/signIn.php";
}

function postSignIn(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    validateRequiredParameters(["username", "password", "email"]);
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];
    try {
        persistAccount($username, $email, $password);
        header("Location: /index", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {
        if (str_contains($exception->getMessage(), "username"))
            $errorMessage = "El nombre de usuario ya está en uso";
        else if (str_contains($exception->getMessage(), "email"))
            $errorMessage = "El correo electrónico ya está vinculada a otra cuenta";
        else $errorMessage = "Se ha producido un error al intentar registrar tu cuenta. Si el error persiste contacta
            con el soporte.";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/signIn.php";
    }
}

function getProfile(): void {
    $userAccount = getUserAccountFromSession();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/profile.view.php";
}

function postProfile(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    validateRequiredParameters(["password"]);

    $userAccount = getUserAccountFromSession();
    print_r($userAccount);
    $usernameTemp = $userAccount["username"];
    $emailTemp = $userAccount["email"];
    $passwordTemp = $userAccount["password"];
    if (password_verify($_POST["password"], $userAccount["password"])) {
        if (!empty($_POST["username"])) $userAccount["username"] = $_POST["username"];
        if (!empty($_POST["email"])) $userAccount["email"] = $_POST["email"];
        if (!empty($_POST["password_new"]))
            $userAccount["password"] = password_hash($_POST["password_new"], PASSWORD_BCRYPT);
        try {
            updateAccount($userAccount["accountId"], $userAccount["username"],
                $userAccount["email"], $userAccount["password"]);
            addUserAccountToSession($userAccount);
        } catch (ValueError $exception) {
            error_400_BadRequest();
        } catch (Exception $exception) {
            $userAccount["username"] = $usernameTemp;
            $userAccount["email"] = $emailTemp;
            $userAccount["password"] = $passwordTemp;
            if (str_contains($exception->getMessage(), "username"))
                $errorMessage = "El nombre de usuario ya está en uso";
            else if (str_contains($exception->getMessage(), "email"))
                $errorMessage = "El correo electrónico ya está vinculada a otra cuenta";
            else $errorMessage = "Se ha producido un error al intentar registrar tu cuenta. Si el error persiste 
            contacta con el soporte.";
        }
    } else $errorMessage = "Contraseña no es válida";
    print_r($userAccount);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/profile.view.php";
}

function deleteUserAccount(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    try {
        $userAccount = getUserAccountFromSession();
        deleteAccount($userAccount["accountId"]);
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function logout(): void {
    destroySession();
    header("Location: /index", true, 303);
}

function getRecover(): void {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/recover.view.php";
}

//TODO acabar
function postRecover(): void {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/emailHandler.php";
    $email = $_POST["email"];
    sendEmail(null, "Recuperar contraseña");
}
