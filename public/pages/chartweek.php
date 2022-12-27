<?
$today = date("d.m");

$timeline = "'".$today."'";
$truedate = date("d.m-Y H:i");
$truetime = strtotime(date($truedate));

$timeline = "'".date("d.m", strtotime('-1 days',$truetime))."', ".$timeline;
$timeline = "'".date("d.m", strtotime('-2 days',$truetime))."', ".$timeline;
$timeline = "'".date("d.m", strtotime('-3 days',$truetime))."', ".$timeline;
$timeline = "'".date("d.m", strtotime('-4 days',$truetime))."', ".$timeline;
$timeline = "'".date("d.m", strtotime('-5 days',$truetime))."', ".$timeline;
$timeline = "'".date("d.m", strtotime('-6 days',$truetime))."', ".$timeline;
?>



<figure class="highcharts-figure">
    <div id="chartweek"></div>
</figure>

<?
    $last = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` = 43") -> fetch_assoc();
    $second = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` = 18") -> fetch_assoc();
    $dif = number_format($last[value] - $second[value], 5, '.', '');
    $perc = $dif / $second[value] * 100;
    $perc = number_format($perc, 2, '.', '');
?>

<p class="text-center font-bold text-xl mt-4 text-[#CD3ED0]"><?=$dif?>(<?=$perc?>%)</p>
<p>&nbsp;</p>

    
    <?
        $points = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` IN (13,14,15,16,17,18,43)");
        $dots = "";
        while ($point = $points->fetch_assoc()) {
            $dots = $dots.$point[value].", "; 
        }
    ?>
    
    <script>
        Highcharts.chart('chartweek', {
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