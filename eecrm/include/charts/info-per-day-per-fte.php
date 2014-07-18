<?php
$infoSents = getAllInfoSentsByDate($date);
$dates = (is_array($infoSents)) ? array_unique(array_map("getDates", $infoSents)) : '';
$fomattedDates = (is_array($dates)) ? array_map("formatDates", $dates) : '';
$userIds = (is_array($infoSents)) ? array_map("getUsers", $infoSents) : '';

// for each date checks is the users has sent some info.
$data = array();
$i =0;
if (is_array($userIds) && is_array($infoSents)) {
    foreach ($userIds as $user) {
        foreach ($infoSents as $info) {
            if ($info['user_id'] == $user) {
                $data[$i]['name'] = $info['first_name']. " ".$info['last_name'];
                foreach ($dates as $date) {
                    if ($info['action_date'] == $date) {
                        $data[$i]['data'][] = (int)$info['infoCount'];
                    } else {
                        $data[$i]['data'][] = 0;
                    } 
                }
                $i++;
            }
        }
    }
}
$jsonData = array();
$displayDates = json_encode($fomattedDates);

foreach ($data as $dataValue) {
    $jsonData[] = json_encode($dataValue);
}
?>
<script type="text/javascript">
$(function () {

        $('#container').highcharts({
            title: {
                text: 'Info Sent/Day/FTE',
                x: -20 //center
            },
            subtitle: {
                text: 'Info sent for leads',
                x: -20
            },
            xAxis: {
                categories:<?php echo $displayDates;?>
            },
            yAxis: {
                title: {
                    text: 'Count of Info sents'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [<?php echo implode(",", $jsonData); ?>]
        });
        
       /* $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Info sent per day'
            },
            subtitle: {
                text: 'By per FTE'
            },
            xAxis: {
                categories: <?php /*echo $displayDates;*/?>,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of infosents',
                    align: 'low'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [<?php /*echo json_encode($jsonData);*/?>]
        });*/
    });
		</script>