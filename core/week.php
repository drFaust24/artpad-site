<?
    include "connect.php";
    if ($artpad) {
        $artpad -> query("UPDATE `charts` as chart SET `value`=(SELECT value FROM `charts` WHERE `id`=chart.id+1) WHERE `id` IN ('13','14','15','16','17','18')");
    }
?>