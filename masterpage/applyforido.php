<? define('artpadadm', true);
    include 'header.php';
    if (($user) AND ($user['access']==10)) { ?>
        <div class="menu">
            <?php
                include 'adminmenu.php';
            ?>
        </div>
        <div class="admincontent">
            <h1>Заявки на IDO</h1>
            <div class="IDO">
                <table style="text-align: center;">
                    <thead>
                        <th style="width: 60px">id</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>e-mail</th>
                        <th>Описание</th>
                    </thead>
                    <tbody>
                        <?
                            if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                            } else {
                                $pageno = 1;
                            }
                            $size_page = 10;
                            $offset = ($pageno-1) * $size_page;
                            $rows_cnt = $artpad->query("SELECT * FROM `apply`")->num_rows;
                            $total_pages = ceil($rows_cnt / $size_page);
                            
                            $qsubscribers = "SELECT * FROM `apply` ORDER BY id DESC LIMIT $offset, $size_page";
                            $rsubscribers = $artpad->query($qsubscribers);
                            while ($rsubscriber = $rsubscribers->fetch_assoc()) {
                                echo "<tr><td style=\"width: 60px\">".$rsubscriber[id]."</td><td>".$rsubscriber[name]."</td><td>".$rsubscriber[phone]."</td><td>".$rsubscriber[email]."</td><td>".$rsubscriber[descr]."</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
                
                <ul class="pagination">
                    <li><a href="?pageno=1">First</a></li>
                    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                    </li>
                    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                </ul>
            </div>
        </div>
        <? include 'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>