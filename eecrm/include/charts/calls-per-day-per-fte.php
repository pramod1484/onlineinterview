<?php
 
require_once dirname(__DIR__)."/utils-login.php";

$date = getFormattedDate(NULL,"Y-m-d");
$fromDate = '2014-05-28';
$toDate = '2014-05-29';

$calls = getAllCallsByDate($fromDate,$toDate);
$userNames = (is_array($calls)) ? array_values(array_unique(array_map("getUsersName", $calls))) : '';

$callsDates = (is_array($calls)) ? array_values(array_unique(array_map("getCallDates", $calls))) : '';
$graphDates = (is_array($callsDates)) ? array_map("formatDates", $callsDates) : '';
$userIds = (is_array($calls)) ? array_values(array_unique(array_map("getUsers", $calls))) : '';

$info = array();
if (is_array($userIds)) {
    foreach ($userIds as $key => $user) {
        $info[$user] = array();
        $info[$user]['name'] = $userNames[$key];
        foreach ($callsDates as $callDate) {
            foreach ($calls as $call) {
                if ($call['created_at'] == $callDate && $user == $call['user_id']) {
                    $info[$user][$callDate] = $call['callcount'];
                } 
            }
        }
    }
}
 
$hoursWorked = (is_array($userIds)) ? getUsersWorkedHours(implode(",", $userIds),$fromDate,$toDate) : '';

$perHoursCall = array();
foreach ($info as $key => $userInfo) {
    $perHoursCall[$key]['name'] = $userInfo['name'];
    foreach ($callsDates as $callDate) {
        if (array_key_exists($callDate, $userInfo) && is_array($hoursWorked)) {
            foreach ($hoursWorked as $userWork) {
                if ($key == $userWork['login_id'] && $callDate == $userWork['login_date']) {
                    $perHoursCall[$key][$callDate] = (int) $userInfo[$callDate];
                    if ($userWork['hours_worked'] >= 1) {
                        $perHoursCall[$key][$callDate] = (int) floor($userInfo[$callDate] / $userWork['hours_worked']);
                    }
                }
            }            
        } else {
            $perHoursCall[$key][$callDate] = 0;
        }
    }
}



$callData = array();
$index = 0;
foreach ($perHoursCall as $call) {
    $callData[$index]['name'] = $call['name'];
    foreach ($callsDates as $call_date) {
        $callData[$index]['data'][] = $call[$call_date];
    }   
    $index++;
}

$callingDates = json_encode($graphDates);
$jsonCallData = json_encode($callData);

?>
<script type="text/javascript">
$(function () {
             $('#callcontainer').highcharts({
            title: {
                text: 'Calls/Hour/Day/FTE',
                x: -20 //center
            },
            subtitle: {
                text: 'Calls For leads',
                x: -20
            },
            xAxis: {
                categories:<?php echo $callingDates;?>
            },
            yAxis: {
                title: {
                    text: 'No Of Calls'
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
            series: <?php echo $jsonCallData; ?>
        });
    });
</script>