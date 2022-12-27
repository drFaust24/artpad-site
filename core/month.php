<?
    include "connect.php";
    if ($artpad) {
        $artpad -> query("UPDATE `charts` as chart SET `value`=(SELECT value FROM `charts` WHERE `id`=chart.id+1) WHERE `id` IN ('1','2','3','4','5','6','7','8','9','10','11','12')");
    }
?>