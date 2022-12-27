<script>
    function chart(period) {
        $.ajax({
            url: '../../chart.php',
            type: 'POST',
            data: {
                period: period
            },
            success: function(response) {
                document.getElementById('code').innerHTML = response;
            }
        });
    }
</script>


<? include "core/connect.php";
if (isset($_POST)) {
    $period = $_POST['period'];
    switch ($period) {
        case 'h':
            $query = "SELECT `value` FROM `charts` WHERE `id` >= 32";
            break;
        case 'd':
            $query = "SELECT `value` FROM `charts` WHERE `id` IN (19,20,21,22,23,24,25,26,27,28,29,30,43)";
            break;
    }
    $points = $artpad -> query($query);
    $dots = "";
    while ($point = $points->fetch_assoc()) {
        $dots = $dots.$point[value].", "; 
    }
    //echo ($dots);
    print_r("
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
        }
    },
    
    legend: {
        enabled: undefined,
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    
    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 2010
        }
    },
    
    series: [{
        name: '',
        data: [".$dots."]
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
    
    
    ");
}
    
?>