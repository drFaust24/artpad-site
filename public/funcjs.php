<?
    include_once '../config.php';
    include_once CORE_DIR.'connect.php';

$idform = $_POST['func'];
if (isset($_POST["email"])) { ?>
    
    <script>
    alert(<?=$idform?>);
    </script>
<? 
    return "success";
}
?>