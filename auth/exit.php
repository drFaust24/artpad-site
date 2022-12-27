<?php
include '../config.php';
//include_once AUTH_DIR.'handler.php'; // проверяем авторизирован ли пользователь

if(!empty($_COOKIE['username']) AND !empty($_COOKIE['password'])) {
    echo $_COOKIE['username']." - ".$_COOKIE['password'];
}

// проверяем авторизацию пользователя
if(!empty($_COOKIE['username']) AND !empty($_COOKIE['password'])) {
    echo "+";
    setcookie('username', '', time()-1, '/');
    setcookie('password', '', time()-1, '/');
    session_destroy();
    echo 'Вы успешно вышли!';
    header("Location: /");
} else {
    echo "-";
    echo 'Для этого действия нужно авторизироваться.';
}
?>