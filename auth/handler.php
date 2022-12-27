<?php
    // проверяем заполнены ли логин и пароль в куках
    if(!empty($_COOKIE['username']) AND !empty($_COOKIE['password'])) {
        $queryuser = "SELECT * FROM `users` WHERE `login` = '".$artpad->real_escape_string($_COOKIE['username'])."' AND `password` = '".$artpad->real_escape_string($_COOKIE['password'])."'";
        $search_user = $artpad->query($queryuser);
        $user = (mysqli_num_rows($search_user) == 1) ? mysqli_fetch_array($search_user) : 0;
    } else {
        $user = 0;
    }
?>