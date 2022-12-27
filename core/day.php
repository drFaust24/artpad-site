<?
    include "connect.php";
    if ($artpad) {
        $artpad -> query("UPDATE `charts` as chart SET `value`=(SELECT value FROM `charts` WHERE `id`=chart.id+1) WHERE `id` IN ('19','20','21','22','23','24','25','26','27','28','29','30')");
    }
?>