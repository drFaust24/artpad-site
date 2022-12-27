<?
    include_once '../../config.php';
    include_once CORE_DIR.'connect.php';
if (isset($_POST["func"])) {
    if (($_POST['func'] == 1) AND (!empty($_POST['acc']))) {
        if(!empty($_COOKIE['username'])) {
            $wallet = $artpad -> query("SELECT `wallet` FROM `users` WHERE `login`='$_COOKIE[username]'")->fetch_assoc();
            $wallet = $wallet['wallet'];
            if (empty($wallet)) {
                $qwallet ="UPDATE `users` SET `wallet`='$_POST[acc]' WHERE `login`='$_COOKIE[username]'";
                $artpad -> query($qwallet);
            }
        }
    }
    if (($_POST['func'] == 2) AND (!empty($_POST['holder'])) AND (!empty($_POST['tier']))) {
            $qtier ="UPDATE `users` SET `lvl`='$_POST[tier]' WHERE `wallet`='$_POST[holder]'";
            $artpad -> query($qtier);
    }
    if (($_POST['func'] == 3) AND (!empty($_POST['holder'])) AND (isset($_POST['amount']))) {
        $instake = $_POST['amount'];
        $holder = ($_POST['holder']);
        $instake = $_POST['amount'];
        $instakebd = $artpad -> query("SELECT `instake` FROM `users` WHERE `wallet`='$holder'") -> fetch_assoc()[instake];
        if ($instakebd != $instake) {
            if ($instake >= 575000) {
                $lvl = 10;
            } else {
                if ($instake >= 325000) {
                    $lvl = 9;
                } else {
                    if ($instake >= 250000) {
                        $lvl = 8;
                    } else {
                        if ($instake >= 100000) {
                            $lvl = 7;
                        } else {
                            if ($instake >= 50000) {
                                $lvl = 6;
                            } else {
                                if ($instake >= 25000) {
                                    $lvl = 5;
                                } else {
                                    if ($instake >= 10000) {
                                        $lvl = 4;
                                    } else {
                                        if ($instake >= 7000) {
                                            $lvl = 3;
                                        } else {
                                            if ($instake >= 5000) {
                                                $lvl = 2;
                                            } else {
                                                if ($instake >= 2500) {
                                                    $lvl = 1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $qtotal ="UPDATE `users` SET `instake`='$instake',`lvl`='$lvl' WHERE `wallet`='$holder'";
            $artpad -> query($qtotal);
        }
    }
    if (($_POST['func'] == 4) AND (isset($_POST['holder'])) AND (isset($_POST['stake']))) {
        echo "UPDATE $_POST[holder] and $_POST[stake]";
    }
}
?>