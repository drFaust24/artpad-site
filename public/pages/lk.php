<script>
    window.addEventListener('DOMContentLoaded', () => {
        let result;
        holder = String('<?=$user['wallet']?>');
        getAmount(holder).then(result => {
            $.ajax({
                url: '/public/js/funcjs.php',
                type: 'POST',
                data: {
                    func: '3',
                    amount: result,
                    holder: holder
                },
                success: function(sql){
                    console.log(sql);
                }
            })
        });
        
    });
</script>

<h1>Личный кабинет пользователя <?=$user['login']?></h1>

<div class="kabinet">
    <input type="radio" name="odin" checked="checked" id="vkl1"/>
    <label for="vkl1">Персональные данные</label>
    <input type="radio" name="odin" id="vkl2"/>
    <label for="vkl2">Стейкинг</label>
    <input type="radio" name="odin" id="vkl3"/>
    <label for="vkl3">Реферальная программа</label>
    <input type="radio" name="odin" id="vkl4"/>
    <label for="vkl4">Поданые заявки</label>
    <input type="radio" name="odin" id="vkl5"/>
    <label for="vkl5">Активные заявки</label>
    <div>
        Имя: <?=$user['name']?><br>
        Фамилия: <?=$user['surname']?><br><br>
        Кошелек: <?=$user['wallet']?>
    </div>
    <div>
        <? /*<table>
            <thead>
                <th>№</th>
                <th>Сумма</th>
                <th>Дата стейкинга</th>
                <th>Период</th>
            </thead>
            <tbody>
                <?
                    $num = 1;
                    $summ = 0;
                    $qstaking = "SELECT * FROM `staking` WHERE user = '$user[id]'";
                    $rstakings = $artpad -> query($qstaking);
                    while ($rstaking = $rstakings->fetch_assoc()) {
                        echo "<tr><td>".$num."</td><td>".$rstaking['sum']."</td><td>".$rstaking['dateofstake']."</td><td>".$rstaking['period']."</td></tr>";
                        $num++;
                        $summ += $rstaking['sum'];
                    }
                    echo "<tr><td>Итого</td><td>".$summ."</td><td></td><td></td></tr>";
                ?>
            </tbody>
        </table> */ ?>
        Сейчас в стейкинге находится: <?=$user['instake']?> ARTR
        <br><br>
        Уровень: <?=$user['lvl']?><br>
        <?
            $qallok = "SELECT * FROM `levels` WHERE lvl = '$user[lvl]'";
            $rallok = $artpad -> query($qallok);
            $allok = $rallok -> fetch_assoc();
        ?>
        Аллокация: <? if ($user['lvl'] < 4) {
            echo $allok['weight']."%";
        } else {
            echo "x".$allok['weight'];
        } ?><br>
        До следующего уровня: <? if ($user['instake'] < 2500) {
            echo (2500 - $user['instake']);
        } else {
            echo ($allok['max'] - $user['instake'] + 1);
        } ?>
    </div>
    <div>
        Ваша реферальная ссылка: <? echo $_SERVER['HTTP_HOST']."?ref=".$user['id']; ?> <img id="copyref" src="/public/img/svg/copy.svg" onclick="copyref('https://<?=$_SERVER['HTTP_HOST']?>?ref=1')"><br><br>
        <? if ($user['ref'] != 0) {
            echo "Вас пригласил: <br>";
        }?>
        Вы пригласили:<br>
        <?
            $qrefs = "SELECT * FROM `users` WHERE ref = '$user[id]'";
            $rrefs = $artpad -> query($qrefs);
            $i = 1;
            while ($rref = $rrefs->fetch_assoc()) {
                echo $i.". ".$rref['login']."<br>";
                $i++;
            }
        ?>
    </div>
    <div>
        <table>
            <thead>
                <th>№</th>
                <th>Сумма</th>
                <th>Дата окончания заявок</th>
                <th>Статус</th>
                <th></th>
            </thead>
            <tbody>
                <?
                    $qrequests = "SELECT * FROM `requests` WHERE `user` = '$user[id]' AND `active` = '1'";
                    $rrequests = $artpad -> query($qrequests);
                    $j = 1;
                    while ($rrequest = $rrequests->fetch_assoc()) {
                        $qproject = "SELECT * FROM `projects` WHERE `id` = '$rrequest[project]'";
                        $rproject = $artpad -> query($qproject);
                        $project = $rproject -> fetch_assoc();
                        if (($project['project_status'] == 'upcoming') OR ($project['project_status'] == 'ended')) {
                            echo "<tr><td>".$j."</td><td>".$project['project_title']."</td><td>".$project['project_listing']."</td><td>".$project['project_status']."</td><td><a href=\"/projects/".$project['project_name']."\">Перейти</a></td></tr>";
                            $j++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div>
        <table>
            <thead>
                <th>№</th>
                <th>Сумма</th>
                <th>Дата окончания заявок</th>
                <th>Статус</th>
                <th></th>
            </thead>
            <tbody>
                <?
                    $qrequests2 = "SELECT * FROM `requests` WHERE `user` = '$user[id]' AND `active` = '1'";
                    $rrequests2 = $artpad -> query($qrequests2);
                    $w = 1;
                    while ($rrequest = $rrequests2->fetch_assoc()) {
                        $qproject = "SELECT * FROM `projects` WHERE `id` = '$rrequest[project]'";
                        $rproject = $artpad -> query($qproject);
                        $project = $rproject -> fetch_assoc();
                        if ($project['project_status'] == 'refunded') {
                            echo "<tr><td>".$j."</td><td>".$project['project_title']."</td><td>".$project['project_listing']."</td><td>".$project['project_status']."</td><td><a href=\"/projects/".$project['project_name']."\">Перейти</a></td></tr>";
                            $w++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function copyref(ref) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(ref).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>