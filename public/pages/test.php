<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<div class="timeframe border border-[#6B1495] rounded-3xl px-4 py-0.5 font-semibold text-[15px]">
    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0]" onclick="hour()">1H</button>
    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0]" onclick="day()">1D</button>
    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0]" onclick="week()">1W</button>
    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0]" onclick="month()">1M</button>
</div>

<div>
    <div id="hour">hour</div>
    <div id="day" style="display: none">day</div>
    <div id="week" style="display: none">week</div>
    <div id="month" style="display: none">month</div>
</div>

<script>
    function hour() {
        document.getElementById('hour').style.display='block';
        document.getElementById('day').style.display='none';
        document.getElementById('week').style.display='none';
        document.getElementById('month').style.display='none';
    }
    function day() {
        document.getElementById('hour').style.display='none';
        document.getElementById('day').style.display='block';
        document.getElementById('week').style.display='none';
        document.getElementById('month').style.display='none';
    }
    function week() {
        document.getElementById('hour').style.display='none';
        document.getElementById('day').style.display='none';
        document.getElementById('week').style.display='block';
        document.getElementById('month').style.display='none';
    }
    function month() {
        document.getElementById('hour').style.display='none';
        document.getElementById('day').style.display='none';
        document.getElementById('week').style.display='none';
        document.getElementById('month').style.display='block';
    }
    /*const list = document.querySelectorAll('.timeframe button')
     list.forEach(item =>{ 
            item.addEventListener('click', (e) =>{
            list.forEach(el=>{ el.classList.remove('active'); });
            item.classList.add('active')
        })
    })*/
</script>

<? date_default_timezone_set('Europe/Moscow');
$minutes = date("i");
$timeline = array();
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
        <div id="chart"></div>
    </figure>

<div id="code">
    
    <?
        $points = $artpad -> query("SELECT `value` FROM `charts` WHERE `id` >= 32");
        $dots = "";
        while ($point = $points->fetch_assoc()) {
            $dots = $dots.$point[value].", "; 
        }
    ?>
    
    <script>
        Highcharts.chart('chart', {
        
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
            }
        },
        
        series: [{
            name: '',
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
</div>

