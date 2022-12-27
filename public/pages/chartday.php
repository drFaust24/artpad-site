<?
$truedate = date("H").":00";
$timeline = "'".$truedate."'";

$truetime = strtotime(date($truedate))."<br>";

$timeline = "'".date("H:i", strtotime('-2 hours',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-4 hours',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-6 hours',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-8 hours',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-10 hour',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-12 hour',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-14 hour',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-16 hour',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-18 hour',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-20 hour',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-22 hour',$truetime))."', ".$timeline;
$timeline = "'".date("H:i", strtotime('-24 hour',$truetime))."', ".$timeline;
?>



<figure class="highcharts-figure">
    <div id="chartday"></div>
</figure>

<?
    $last = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` = 43") -> fetch_assoc();
    $second = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` = 30") -> fetch_assoc();
    $dif = number_format($last[value] - $second[value], 5, '.', '');
    $perc = $dif / $second[value] * 100;
    $perc = number_format($perc, 2, '.', '');
?>

<p class="text-center font-bold text-xl mt-4 text-[#CD3ED0]"><?=$dif?>(<?=$perc?>%)</p>
<p>&nbsp;</p>

    
    <?
        $points = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` IN (19,20,21,22,23,24,25,26,27,28,29,30,43)");
        $dots = "";
        while ($point = $points->fetch_assoc()) {
            $dots = $dots.$point[value].", "; 
        }
    ?>
    
    <script>
        Highcharts.chart('chartday', {
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