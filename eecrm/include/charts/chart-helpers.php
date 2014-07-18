<?php
function getDates($arr) {
    return $arr['action_date'];
}

function formatDates($arr) {
    return date("d M,y",strtotime($arr));
}

function getUsers($arr) {
    return $arr['user_id'];
}

function getUsersName($arr) {
    return $arr['first_name']." ".$arr['last_name'];
}

function getCalls($callsArray) {
    return (int) $callsArray['calls'];
}

function getCallDates($calls) {
    return $calls['created_at'];
}

/**
 * All dates between two dates.
 * 
 * @param date $from
 * @param date $to
 * @return array
 */
function getAllDates($from,$to)
{
    $dates = array();
    $fromdate = new DateTime($from);
    $todate = new DateTime($to);
    $datePeriod = new \DatePeriod(
           $fromdate,
           new \DateInterval('P1D'),
           $todate->modify('+1 day')
       );
    
    
    foreach($datePeriod as $date) {
        $dates[] = $date->format('Y-m-d');
    }       
    
    return $dates;
}

function getData($arr) {
    return (int)$arr;
}