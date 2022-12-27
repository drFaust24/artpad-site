<?
    function truedate($date) {
        $date = explode("-", $date);
        $truedate = $date[2].".".$date[1].".".$date[0];
        echo $truedate;
    }
    function truedatetime($date) {
        $date = explode(" ", $date);
        $time = $date[1];
        $date = explode("-", $date[0]);
        $time = explode(":", $time);
        $truedate = $time[0].":".$time[1]." ".$date[2].".".$date[1].".".$date[0];
        echo $truedate;
    }
    
    function breadcrumbs() {
        echo "<div class=\"breadcrumbs\">";
        echo "<a href=\"masterpage\">Главная</a> >";
        echo "</div>";
    }
    
    function translit($strg) {
        $str = mb_strtolower($strg);
        $str = strtr($str, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'',' '=>'-'));
        return $str; // возвращаем результат
    }
    
    function uploadfile($type,$id,$file) {
        switch ($type) {
            case "user":
                $uploaddir = UPLOAD_DIR.'users/';
                break;
            case "token":
                $uploaddir = UPLOAD_DIR.'tokens/';
                break;
        }
        if ($file && $file["error"]== UPLOAD_ERR_OK) {
            $falename = explode(".",$file['name']);
            $name = $id.".".$falename[1];
            $uploadfile = $uploaddir . basename($name);
            move_uploaded_file($file["tmp_name"], $uploadfile);
        }
    }
    
    
    /* Public functions*/
    function showmenu($idmenu,$lang) {
        global $artpad;
        if (empty($lang)) {$lang='en';}
        $qmenu ="SELECT `pages` FROM `menu` WHERE id = $idmenu";
        $rmenu = $artpad -> query($qmenu);
        $rmen = $rmenu->fetch_assoc();
        $pages = explode( ',', $rmen['pages'] );
        echo "<nav class=\"nav\">";
        echo "<ul class=\"nav__list\">";
        $currpage = str_replace("/", "", $_SERVER['REQUEST_URI']);
        foreach ($pages as $page) {
            $qpage ="SELECT page_title,$lang,page_name,page_status FROM `pages` WHERE `id` = $page";
            $rpage = $artpad -> query($qpage);
            $rpage = $rpage->fetch_assoc();
            if ($rpage['page_status'] == 1) { ?>
                <li class="nav__item">
                    <a href="/<?=$rpage['page_name']?>" class="nav__link <?if ($currpage==$rpage['page_name']) {echo "link-selected"; }?>"><?=$rpage[$lang]?></a>
                </li>
            <? }
        }
        echo "</ul>";
        echo "</nav>";
    }
    function showfootmenu($idmenu,$lang) {
        global $artpad; 
        if (empty($lang)) {$lang='en';}
        $qmenu ="SELECT `pages` FROM `menu` WHERE id = $idmenu";
        $rmenu = $artpad -> query($qmenu);
        $rmen = $rmenu->fetch_assoc();
        $pages = explode( ',', $rmen['pages'] );
        echo "<ul class=\"footer__list\">";
        $currpage = str_replace("/", "", $_SERVER['REQUEST_URI']);
        foreach ($pages as $page) {
            $qpage ="SELECT page_title,$lang,page_name,page_status FROM `pages` WHERE `id` = $page";
            $rpage = $artpad -> query($qpage);
            $rpage = $rpage->fetch_assoc();
            if ($rpage['page_status'] == 1) { ?>
                <li class="footer__item">
                    <a href="/<?=$rpage['page_name']?>" class="footer__link <?if ($currpage==$rpage['page_name']) {echo "link-selected"; }?>"><?=$rpage[$lang]?></a>
                </li>
            <? }
        }
        echo "</ul>";
    }
    
    function showmobmenu($idmenu,$lang) {
        global $artpad; 
        if (empty($lang)) {$lang='en';}
        $qmenu ="SELECT `pages` FROM `menu` WHERE id = $idmenu";
        $rmenu = $artpad -> query($qmenu);
        $rmen = $rmenu->fetch_assoc();
        $pages = explode( ',', $rmen['pages'] );
        echo "<nav class=\"mob-nav\">";
        echo "<ul class=\"mob-nav__item\">";
        $currpage = str_replace("/", "", $_SERVER['REQUEST_URI']);
        foreach ($pages as $page) {
            $qpage ="SELECT page_title,$lang,page_name,page_status FROM `pages` WHERE `id` = $page";
            $rpage = $artpad -> query($qpage);
            $rpage = $rpage->fetch_assoc();
            if ($rpage['page_status'] == 1) { ?>
                <li class="mob-nav__item">
                    <a href="/<?=$rpage['page_name']?>" class="mob-nav__link<?if ($currpage==$rpage['page_name']) {echo " link-selected"; }?> py-3"><?=$rpage[$lang]?></a>
                </li>
            <? }
        }
        echo "</ul>";
        echo "</nav>";
    }
    
    function content($curpage) {
        global $artpad;
        global $user;
        global $arrLang;
        $crpage = str_replace("/", "", $_SERVER['REQUEST_URI']);
        
        if (($_SERVER['REQUEST_URI'] == "/lk/") AND (!$user)) { ?>
            <script type="text/javascript">
              location="/";
            </script>
        <? }
        
        if (file_exists(PUBLIC_DIR."pages/".$crpage.".php")) {
            include PUBLIC_DIR."pages/".$crpage.".php";
        } else {
            $curpages = array_values(array_diff(explode("/", $curpage), array('')));
            if ($curpages[0] == "projects") {
                include PUBLIC_DIR."pages/project.php";
                
            } else { ?>
            <script type="text/javascript">
              location="/";
            </script>
        <? 
                
                /*$curpages = end($curpages);
                $qcontpage ="SELECT page_content FROM `pages` WHERE `page_name`='$curpages'";
                print_r($qcontpage);
                //$rcontpage = $artpad -> query($qcontpage);
                //print_r($rcontpage);*/
            }
        }
        
    }
?>