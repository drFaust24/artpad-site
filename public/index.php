<? if (!defined('artpad')) exit('No direct script access allowed');
    // получаем настройки сайта
    session_start();
    $qstgs ="SELECT name,value FROM `settings`";
    $rstgs = $artpad -> query($qstgs);
    $settings = array();
    while ($setting = $rstgs->fetch_assoc()) {
        $settings[$setting[name]] = $setting[value];
    }
    if (isset($_GET['ref'])) {
        $ref=$_GET['ref'];
        $time = 60*60*24*30; // сколько времени хранить данные в куках
        setcookie('ref', $ref, time()+$time, '/');
    }
    
    include AUTH_DIR.'handler.php';
    
    if (empty($_SESSION['language'])) {
        $language = 'en';
        $_SESSION['language'] = $language;
    } else {
        $language = $_SESSION['language'];
    }
    if ($user) {
        $language = $artpad -> query("SELECT `lang` FROM `users` WHERE `id`='$user[id]'");
        $language = $language -> fetch_assoc()['lang'];
        $_SESSION['language'] = $language;
    }
    if (!empty($_GET['language'])) {
        $language=$_GET['language'];
        $_SESSION['language'] = $language;
        $artpad -> query("UPDATE `users` SET `lang` = '$language' WHERE `id` = '$user[id]'");
    }
    
    include SITE_DIR.'languages/'.$language.'.php';
    
    include 'header.php';
        
    if ($_SERVER['REQUEST_URI'] == "/") {
        include 'home.php';
    } else {
        include 'page.php';
    }
    
    include 'footer.php';
    
?>