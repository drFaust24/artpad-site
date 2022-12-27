<?
$minutes = date("i");
$ost = $minutes % 10;
switch ($ost) {
    case '0':
        $truedate = date("H:i");
        $timeline = "'".$truedate."'";
        break;
    case '1':
        $truedate = date('H:i',strtotime('-60 seconds'));
        $timeline = "'".$truedate."'";
        break;
    case '2':
        $truedate = date('H:i',strtotime('-120 seconds'));
        $timeline = "'".$truedate."'";
        break;
    case '3':
        $truedate = date('H:i',strtotime('-180 seconds'));
        $timeline = "'".$truedate."'";
        break;
    case '4':
        $truedate = date('H:i',strtotime('-240 seconds'));
        $timeline = "'".$truedate."'";
        break;
    case '5':
        $truedate = date("H:i");
        break;
    case '6':
        $truedate = date('H:i',strtotime('-60 seconds'));
        $timeline = "'".$truedate."'";
        break;
    case '7':
        $truedate = date('H:i',strtotime('-120 seconds'));
        $timeline = "'".$truedate."'";
        break;
    case '8':
        $truedate = date('H:i',strtotime('-180 seconds'));
        $timeline = "'".$truedate."'";
        break;
    case '9':
        $truedate = date('H:i',strtotime('-240 seconds'));
        $timeline = "'".$truedate."'";
        break;
}

$truetime = strtotime(date($truedate))."<br>";

$timeline = "'".date("H:i", strtotime('-5 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-10 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-15 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-20 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-25 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-30 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-35 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-40 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-45 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-50 minutes',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-55 minutes',$truetime))."', ".$timeline;
?>



<figure class="highcharts-figure">
    <div id="charthour"></div>
</figure>

<?
    $last = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` = 43") -> fetch_assoc();
    $second = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` = 42") -> fetch_assoc();
    $dif = number_format($last[value] - $second[value], 5, '.', '');
    $perc = $dif / $second[value] * 100;
    $perc = number_format($perc, 2, '.', '');
?>

<p class="text-center font-bold text-xl mt-4 text-[#CD3ED0]"><?=$dif?>(<?=$perc?>%)</p>
<p>&nbsp;</p>

    
    <?
        $points = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` >= 32");
        $dots = "";
        while ($point = $points->fetch_assoc()) {
            $dots = $dots.$point[value].", "; 
        }
    ?>
    
    <script>
        Highcharts.chart('charthour', {
    	    chart: {
                backgroundColor:'#000000' 
    	    },
        
            title: {
                text: ''
            },
            
            subtitle: {
                text: ''
            },
            
            yAxis: {
                title: {
                    text: ''
                }
            },
            
            xAxis: {
                accessibility: {
                    rangeDescription: ''
                },
                categories: [<?=$timeline?>]
            },
            
            legend: {
                enabled: undefined
            },
            
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                },
                area: {
                  fillColor: {
                    linearGradient: {
                      x1: 0,
                      y1: 0,
                      x2: 0,
                      y2: 1
                    },
                    stops: [
                      [0, '#cd3ed0'],
                      [1, '#00000030']
                    ]
                  },
                  threshold: null
                }
            },
            
            series: [{
                name: '',
                type: 'area',
                color: "#cd3ed0",
                data: [<?=$dots?>]
            }],
            
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        
        });
    </script>