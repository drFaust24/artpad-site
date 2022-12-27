<?
    include "connect.php";
    if ($artpad) {
        $pair = 'artr_usdt';
        $curtime = time();
    
        $info = file_get_contents('https://api.lbkex.com/v2/supplement/ticker/price.do?symbol='.$pair);
        $info = json_decode($info, true);
        
        $val = $info[data][0][price];
        
        print_r($val);
        
        $artpad -> query("UPDATE `charts` as chart SET `value`=(SELECT value FROM `charts` WHERE `id`=chart.id+1) WHERE `id` IN ('31','32','33','34','35','36','37','38','39','40','41','42')");
        if ($val != 0) {
            $artpad -> query("UPDATE `charts` SET `value` = '$val' WHERE `id` = 43;");
        } else {
            $artpad -> query("UPDATE `charts` as chart SET `value` = (SELECT value FROM `charts` WHERE `id`=42) WHERE `id` = 43;");
        }
    }
?>