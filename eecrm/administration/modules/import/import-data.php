<?php
/**
 * 
 */
require_once dirname(__DIR__)."/../../include/database.php";
require_once dirname(__DIR__)."/../../include/define.php";
require_once dirname(__DIR__)."/../../include/utils-helpers.php";
require_once dirname(__DIR__)."/../../include/utils-leads.php";

if (!empty($_POST['import-entity-type']) && !empty($_POST['fileName'])){
    $file_handle = fopen(BASEPATH.'data/upload/'.$_POST['fileName'], "r");
    if ($file_handle !== false) {
            $i = 0;
            $rowArray = array();
            try {
                while (($data = fgetcsv($file_handle, 1024, ",")) !== false) {
                    if ($i === 0) {
                        foreach ($data as $key => &$value) {
                            $rowArray[] = $value;
                        }
                    } else {
                        $j = 0;
                        $dataArray = array();
                        foreach ($data as $key => &$value) {
                            $dataArray[$rowArray[$j]] = $value;
                            if (is_string($value)) {
                               $dataArray[$rowArray[$j]] = escapeString($value); 
                            }
                            $j++;
                        }
                        addNewLeadDetails($dataArray);
                    } 
                    $i++;
                }
                fclose($file_handle);
                $response['valid'] = 1;
            } catch (Exception $exc) {
                $response['valid'] = 0;
                $response['str'] = $exc->getMessage();
            }             
            
            @header("Content-type: text/json");
            $jsonResponse = json_encode($response);
            echo $jsonResponse;    
            exit;
      }
}