<?
$projectname = explode("/", $_SERVER['REQUEST_URI']);
$projectname = end($projectname);
$qproject ="SELECT * FROM `projects` WHERE `project_name`='$projectname'";
$rproject = $artpad -> query($qproject);
$project = $rproject->fetch_array(MYSQLI_ASSOC);

if (isset($_POST['request'])) {
    $proverka = $artpad->query("SELECT * FROM `requests` WHERE `user`='$user[id]' AND `project` = '$project[id]' AND `active` = '1'");
    $cnt = $proverka->num_rows;
    if ($cnt == 0) {
        $dt = date("Y-m-d H:i:s", strtotime('+3 hours'));
        $qreqest = "INSERT INTO `requests`(`user`, `project`, `active`, `dateofreq`) VALUES ('$user[id]','$project[id]','1','$dt')";
        $artpad -> query($qreqest);
    }
}
if (isset($_POST['unrequest'])) {
    $dt = date("Y-m-d H:i:s", strtotime('+3 hours'));
    $qunreqest = "UPDATE `requests` SET `active` = '0', `dateofunreq` = '$dt' WHERE `user`='$user[id]' AND `project` = '$project[id]' AND `active` = '1'";
    $artpad -> query($qunreqest);
}

$cost = explode(" ", $project['project_price_ido']); ?>

<div class="_container project row">
    <div class="col-4">
        <div class="border border-2 border-[#CD3ED0] my-4 rounded-md">
            <div>
                <img class="project_logo_big" src="<?=$project['project_logo']?>">
                <div class="project_title"><span class="project_name"><?=$project['project_title']?></span><br>$<?=$project['project_token_small']?></div>
            </div>
            <div style="margin-top: 20px">
                <label class="iconlevels">Levels</label>
                <label class="iconkyc">KYC</label>
            </div>
            <div class="course">
                <h2 style="font-size: 1.5em;">1 USDT = <?=$project['project_token_small']?></h2>
                <h2 style="font-size: 1.5em;">1 <?=$project['project_token_small']?> = USDT</h2>
            </div>
            
            <?
                $regstart = new DateTimeImmutable($project['project_register_start']);
                $regend = new DateTimeImmutable($project['project_register_end']);
                $salestart = new DateTimeImmutable($project['project_sale_start']);
                $saleend = new DateTimeImmutable($project['project_sale_end']);
                $now = new DateTimeImmutable();
                
                if ($regstart > $now) {
                    $status = 1; 
                    $interval = $now->diff($saleend); // получаем разницу в виде объекта DateInterval
                    $text = "Registration will open in ";
                    if ($interval->d > 0) { $text = $text.$interval->d." days";}
                    if (($interval->d > 0) AND (($interval->h-3) >= 0)) { $text = $text.", ";}
                    if (($interval->h-3) >= 0) { $text = $text.($interval->h-3)." hours"; }
                    
                }
                
                if (($regstart < $now) AND ($regend > $now)) {
                    $status = 2; 
                    $interval = $now->diff($saleend); // получаем разницу в виде объекта DateInterval
                    $text = "Registration will end in ";
                    if ($interval->d > 0) { $text = $text.$interval->d." days";}
                    if (($interval->d > 0) AND (($interval->h-3) >= 0)) { $text = $text.", ";}
                    if (($interval->h-3) >= 0) { $text = $text.($interval->h-3)." hours"; }
                }
                
                if (($salestart < $now) AND ($saleend > $now)) {
                    $status = 3; 
                    $interval = $now->diff($saleend); // получаем разницу в виде объекта DateInterval
                    $text = "Sale will end in ";
                    if ($interval->d > 0) { $text = $text.$interval->d." days";}
                    if (($interval->d > 0) AND (($interval->h-3) >= 0)) { $text = $text.", ";}
                    if (($interval->h-3) >= 0) { $text = $text.($interval->h-3)." hours"; }
                }
                
                if ($saleend < $now) {
                    $status = 4; 
                }
                
                if (($regend < $now) AND ($salestart > $now)) {
                    $status = 5; 
                    $interval = $now->diff($saleend); // получаем разницу в виде объекта DateInterval
                    $text = "Sale will open in ";
                    if ($interval->d > 0) { $text = $text.$interval->d." days";}
                    if (($interval->d > 0) AND (($interval->h-3) >= 0)) { $text = $text.", ";}
                    if (($interval->h-3) >= 0) { $text = $text.($interval->h-3)." hours"; }
                }
            ?>
            
            <? if ($status != 4) { ?>
                <div style="margin: 20px 0">
                    <div class="flex justify-between items-center">
                        <p class="text-white 2xl:text-base text-sm">
                            <?=$text?>
                        </p>
                        <p class="text-base text-[#CD3ED0] overflow-ellipsis break-normal">0%</p>
                    </div>
                    <div class="bg-gray-600 rounded-lg h-2 my-2"></div>
                    <div class="flex justify-between items-center text-gray-600 font-semibold">
                        <p class="text-base">0 BUSD</p>
                        <p class="text-base overflow-ellipsis break-normal">0 / <?=$project['project_total_supply']?> <?=$project['project_token_small']?></p>
                    </div>
                </div>
            <? } ?>
            <div>
                <p>
                   IDO amd distribution on BNB Chain 
                </p>
                <p>
                   Register <? echo truedatetime($project['project_register_start'])?> - <? echo truedatetime($project['project_register_end'])?>
                </p>
                <p>
                   Sale <? echo truedatetime($project['project_sale_start'])?> - <? echo truedatetime($project['project_sale_end'])?>
                </p>
            </div>
            
            
            <div style="margin-top: 20px; text-align: center">
                <? switch ($status) {
                    case 1:
                        echo "i равно 2";
                        break;
                    case 2:
                        $result = $artpad->query("SELECT * FROM `requests` WHERE `user`='$user[id]' AND `project` = '$project[id]' AND `active` = '1'");
                        $row_cnt = $result->num_rows;
                        if ($row_cnt == 0) { ?>
                        
                            <form action="" method="POST" target="_self" name="Req" id="Req">
                                <input type="submit" class="btn-primary" name="request" value="Подать заявку" />
                            </form>
                        <? } else { ?>
                            <form action="" method="POST" target="_self" name="Unreq">
                                <input type="submit" class="btn-primary" name="unrequest" value="Отменить заявку" />
                            </form>
                        <? }
                        break;
                    case 3:
                        $claim = $artpad->query("SELECT * FROM `requests` WHERE `user`='$user[id]' AND `project` = '$project[id]' AND `active` = '1' AND `lotery` = '1'");
                        $claim = $claim->fetch_assoc()[claim];?>
                        Вы имеете право на: <span style="color: var(--selected-color);"><?=$claim?> <?=$project['project_token_small']?></span><br>
                        <br>
                        <input type="text" class="notif__input" name="claimval" value=""/>
                        <input type="submit" class="btn-primary" name="claim" value="Claim" />
                        <?
                        break;
                    case 4:
                        echo 'Продажа закончилась';
                        break;
                } ?>
            </div>
            
        </div>
    </div>
    <div class="col-8">
        <div class="border border-2 border-[#CD3ED0] my-4 rounded-md">
            <div>
                <img class="project_logo" src="<?=$project['project_logo']?>"><span class="project_title"><span class="project_name"><?=$project['project_token_small']?></span></span>
            </div>
            <div class="description">
                <?=$project['project_content']?>
            </div>
            <div>
                <h3>Pool details</h3>
                <div>
                    Access type: <?=$project['project_access_type']?>
                </div>
                <div>
                    Hard Cap: ???
                </div>
                <div>
                    Swap Rate: <span style="color: var(--selected-color);">1 <?=$project['project_token_small']?> = <?=$project['project_price_ido']?></span>
                </div>
                <div>
                    Start/end: <? echo truedatetime($project['project_sale_start'])?> - <? echo truedatetime($project['project_sale_end'])?>
                </div>
                <div>
                    Registration: <? echo truedatetime($project['project_register_start'])?> - <? echo truedatetime($project['project_register_end'])?>
                </div>
                <h3>Price</h3>
                <div>
                    IDO: <?=$project['project_price_ido']?>
                </div>
                <h3>Token</h3>
                <div>
                    Token: <?=$project['project_token_full']?> (<?=$project['project_token_small']?>)
                </div>
                <div>
                    Type: <?=$project['project_type']?>
                </div>
                <div>
                    Total Supply: <?=number_format($project['project_total_supply'], 0, '', ' ');?> <?=$project['project_token_small']?>
                </div>
                <div>
                    Initial Supply: <?=number_format($project['project_initial_supply'], 0, '', ' ');?> <?=$project['project_token_small']?>, market cup <?echo number_format($project['project_initial_supply'] * $cost[0], 0, '', ' ')." ".$cost[1]; ?>
                </div>
                <div>
                    Token Listing: <? echo truedatetime($project['project_listing'])?>
                </div>
                <h3>Distribution</h3>
                <div>
                    Distribution: <?=$project['project_distribution']?>
                </div>
                <div>
                    Vesting: <?=$project['project_vesting']?>
                </div>
            </div>
        </div>
    </div>
</div>