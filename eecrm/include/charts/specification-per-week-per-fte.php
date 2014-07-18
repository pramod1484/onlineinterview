<?php

require_once dirname(__DIR__)."/utils-users-efforts.php";

///$date = getFormattedDate(NULL,"Y-m-d");
$mondayOfWeek = new DateTime("Monday this week");
$fridayOfWeek = new DateTime("Friday this week");

$fromDate = $mondayOfWeek->format('Y-m-d');
$toDate = $fridayOfWeek->format('Y-m-d');
$weekDates = getAllDates($fromDate,$toDate);

$specifications = getAllEffortsOfUserByDates($fromDate,$toDate);
$specificationUserNames = array_values(array_unique(array_map("getUsersName", $specifications)));
$specificationUserIds = array_values(array_unique(array_map("getUsers", $specifications)));
$specificationDisplayDates = array_values(array_map("formatDates", $weekDates));

$specificationInfo = array();
foreach ($specificationUserIds as $key => $user) {
    foreach ($weekDates as $day) {
        $specificationInfo[$user][$day] = 0;
        foreach ($specifications as $specification) {
            if ($specification['efforts_date'] == $day && $specification['user_id'] == $user) {
                $specificationInfo[$user][$day] = $specification['specs_count'];
            }
        }
    }
}

$appointments = array();
$index = 0;
foreach ($specificationUserIds as $key => $user) {
    $appointments[$index]['name'] = $specificationUserNames[$key];
    foreach ($specificationInfo as $infoKey => $info) {
        if ($infoKey == $user) {
            $appointments[$index]['data'] = array_map("getData",array_values($info));
            $index++;
        }
    }
}

?>
<script type="text/javascript">
$(function () {
             $('#sepecificationcontainer').highcharts({
            title: {
                text: 'Specification/Week/FTE',
                x: -20 //center
            },
            subtitle: {
                text: 'Specifications For Opportunities',
                x: -20
            },
            xAxis: {
                categories:<?php echo json_encode($specificationDisplayDates);?>
            },
            yAxis: {
                title: {
                    text: 'No Of Specifications'
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
            series: <?php echo json_encode($appointments); ?>
        });
    });
</script>