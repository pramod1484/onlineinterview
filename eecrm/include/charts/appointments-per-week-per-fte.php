<?php

require_once dirname(__DIR__)."/utils-users-efforts.php";

///$date = getFormattedDate(NULL,"Y-m-d");
$mondayOfWeek = new DateTime("Monday this week");
$fridayOfWeek = new DateTime("Friday this week");

$fromDate = $mondayOfWeek->format('Y-m-d');
$toDate = $fridayOfWeek->format('Y-m-d');
$weekDates = getAllDates($fromDate,$toDate);

$efforts = getAllEffortsOfUserByDates($fromDate,$toDate);
$effortUserNames = array_values(array_unique(array_map("getUsersName", $efforts)));
$effortUserIds = array_values(array_unique(array_map("getUsers", $efforts)));
$effortDisplayDates = array_values(array_map("formatDates", $weekDates));

$effortInfo = array();
foreach ($effortUserIds as $key => $user) {
    foreach ($weekDates as $day) {
        $effortInfo[$user][$day] = 0;
        foreach ($efforts as $effort) {
            if ($effort['efforts_date'] == $day && $effort['user_id'] == $user) {
                $effortInfo[$user][$day] = $effort['appointments_count'];
            }
        }
    }
}

$appointments = array();
$index = 0;
foreach ($effortUserIds as $key => $user) {
    $appointments[$index]['name'] = $effortUserNames[$key];
    foreach ($effortInfo as $infoKey => $info) {
        if ($infoKey == $user) {
            $appointments[$index]['data'] = array_map("getData",array_values($info));
            $index++;
        }
    }
}

?>
<script type="text/javascript">
$(function () {
             $('#appointmentcontainer').highcharts({
            title: {
                text: 'Appointments/Week/FTE',
                x: -20 //center
            },
            subtitle: {
                text: 'Appointments For Opportunities',
                x: -20
            },
            xAxis: {
                categories:<?php echo json_encode($effortDisplayDates);?>
            },
            yAxis: {
                title: {
                    text: 'No Of Apointments'
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