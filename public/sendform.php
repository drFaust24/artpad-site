<?
    include_once '../config.php';
    include_once CORE_DIR.'connect.php';

$idform = $_GET['form'];

switch ($idform) {
    case 1: //subscribe
        if (isset($_POST["email"])) {
            $proverka = $artpad->query("SELECT * FROM `subscribe` WHERE `email`='$_POST[email]'");
            $cnt = $proverka->num_rows;
            if ($cnt == 0) {
                $qaddemail = "INSERT INTO `subscribe`(`email`) VALUES ('$_POST[email]')";
                $artpad -> query($qaddemail);
                $result = "Ваш E-mail успешно добавлен";
            } else {
                $result = "Вы уже подписаны на нашу рассылку";
            }
            print_r($result); 
        }
        break;
    case 2: //apply for IDO
        if ((!empty($_POST["nameapply"])) AND (!empty($_POST["phoneapply"])) AND (!empty($_POST["emailapply"])) AND (!empty($_POST["descripapply"]))) {
            $qaddapply = "INSERT INTO `apply` (`name`, `phone`, `email`, `descr`) VALUES ('$_POST[nameapply]','$_POST[phoneapply]','$_POST[emailapply]','$_POST[descripapply]')";
            $artpad -> query($qaddapply);
            $result2 = "Ваша заявка успешно отправлена. Спасибо!";
            print_r($result2); 
        }
        break;
} ?>