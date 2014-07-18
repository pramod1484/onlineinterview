<?php
/*
 * Returns fields in html for inline editing
 * For for all Modules Inline Edit
 */
require_once dirname(__DIR__).'/include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'utils-entity-teams.php';

$module = sanitizeString($_POST['module']);
$id = sanitizeString($_POST['id']);
$field = sanitizeString($_POST['field']);

require_once $include_directory."utils-$module.php";
          
         switch ($field) {
             case 'name':
                    $select = array('salutation_name', 'first_name', 'last_name');
                    $leadDetails = selectLeadDetails($id, $select);

                    if ($leadDetails !== NULL) { 
                       $salutations = array('' => '', 'Mr.' => 'Mr.', 'Mrs.' => 'Mrs.', 'Dr.' => 'Dr.', 'Drs.' => 'Drs.');
                       $salutationsOptions = htmlSelectOptions($salutations, $leadDetails['salutation_name']);

                       $fieldHtml = '<div class="row">
                                               <div class="col-sm-3">
                                                       <select name="salutation_name" class="form-control updateField">
                                                           ' . $salutationsOptions . '
                                                       </select>		
                                               </div>
                                               <div class="col-sm-4">	
                                                       <input type="text" class="form-control updateField" name="first_name" value="' . $leadDetails['first_name'] . '" placeholder="First Name">
                                               </div>
                                               <div class="col-sm-5">	
                                                       <input type="text" class="form-control updateField" name="last_name" value="' . $leadDetails['last_name'] . '" placeholder="Last Name">
                                               </div>
                                       </div>';
                       echo $fieldHtml;
                    }
                    break;
                 
             case 'address':
                    $select = array('address_street', 'address_city', 'address_state', 'address_country', 'address_postal_code');
                    $leadDetails = ($module == "leads")?selectLeadDetails($id, $select):  selectOpportunityDetails($id,$select);

                    if ($leadDetails !== NULL) { 

                       $fieldHtml = '<input type="text" placeholder="Street" value="' . $leadDetails['address_street'] . '" name="address_street" class="form-control updateField">
                                     <div class="row">
                                           <div class="col-sm-4">
                                               <input type="text" placeholder="City" value="' . $leadDetails['address_city'] . '" name="address_city" class="form-control updateField">
                                           </div>
                                           <div class="col-sm-4">
                                               <input type="text" placeholder="State" value="' . $leadDetails['address_state'] . '" name="address_state" class="form-control updateField">
                                           </div>
                                           <div class="col-sm-4">
                                               <input type="text" placeholder="Postal Code" value="' . $leadDetails['address_postal_code'] . '" name="address_postal_code" class="form-control updateField">
                                           </div>
                                       </div>
                                       <input type="text" placeholder="Country" value="' . $leadDetails['address_country'] . '" name="address_country" class="form-control updateField">';
                       echo $fieldHtml;
                    }
                    break;
                 
             case 'call_status':
                    global $db;
                    $sqlQuery = "SELECT s.`status_id`, s.`status_name`, l.call_status 
                        FROM `call_status` s, $module l 
                        WHERE s.deleted = 0 and l.id = $id AND s.status_id != 7";
                    $stmt = $db->prepare($sqlQuery);
                    $stmt->execute();
                    
                    $fieldHtml = '<select class="form-control main-element updateField" name="call_status">
                                    <option value="">Select</option>';
                    if ($stmt->columnCount() > 0) {
                        $statusArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($statusArr as $status) {
                            $select = ($status['status_id'] == $status['call_status']) ? 'selected="selected"' : '';
                            $fieldHtml .= '<option ' . $select . ' value="' . $status['status_id'] . '">' . $status['status_name'] . '</option>';
                        }
                    }
                    $fieldHtml .= '</select>';
                    echo $fieldHtml;
                    break;
                    case 'status':
                    global $db;
                    $sqlQuery = "SELECT s.`status_id`, s.`status_name`, l.status 
                        FROM `status` s, $module l 
                        WHERE s.deleted = 0 and l.id = $id AND s.status_id != 7";
                    $stmt = $db->prepare($sqlQuery);
                    $stmt->execute();
                    
                    $fieldHtml = '<select class="form-control main-element updateField" name="status">
                                    <option value="">Select</option>';
                    if ($stmt->columnCount() > 0) {
                        $statusArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($statusArr as $status) {
                            $select = ($status['status_id'] == $status['status']) ? 'selected="selected"' : '';
                            $fieldHtml .= '<option ' . $select . ' value="' . $status['status_id'] . '">' . $status['status_name'] . '</option>';
                        }
                    }
                    $fieldHtml .= '</select>';
                    echo $fieldHtml;
                    break;
             case 'source':
                    global $db;
                    $sqlQuery = "SELECT s.`source_id`, s.`source_name`, l.source 
                        FROM `sources` s, $module l 
                        WHERE s.deleted = 0 and l.id = $id";
                    $stmt = $db->prepare($sqlQuery);
                    $stmt->execute();
                    
                    $fieldHtml = '<select class="form-control main-element updateField" name="source">
                                    <option value="">Select</option>';
                    if ($stmt->columnCount() > 0) {
                        $sources = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($sources as $source) {
                            $select = ($source['source_id'] == $source['source']) ? 'selected="selected"' : '';
                            $fieldHtml .= '<option ' . $select . ' value="' . $source['source_id'] . '">' . $source['source_name'] . '</option>';
                        }
                    }
                    $fieldHtml .= '</select>';
                    echo $fieldHtml;
                    break;
                    
            case 'stage':
                global $db;
                $sqlQuery = "SELECT s.`stage_id`, s.`stage_name`, o.stage 
                        FROM `stages` s, $module o 
                        WHERE s.deleted = 0 and o.id = $id";
                $stmt = $db->prepare($sqlQuery);
                $stmt->execute();

                $fieldHtml = '<select class="form-control main-element updateField" name="stage">
                                    <option value="">Select</option>';
                if ($stmt->columnCount() > 0) {
                    $statusArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($statusArr as $status) {
                        $select = ($status['stage_id'] == $status['stage']) ? 'selected="selected"' : '';
                        $fieldHtml .= '<option ' . $select . ' value="' . $status['stage_id'] . '">' . $status['stage_name'] . '</option>';
                    }
                }
                $fieldHtml .= '</select>';
                echo $fieldHtml;
                break;
            
            case 'lead_source':
                global $db;
                $sqlQuery = "SELECT s.`source_id`, s.`source_name`, o.lead_source 
                        FROM `sources` s, $module o 
                        WHERE s.deleted = 0 and o.id = $id";
                $stmt = $db->prepare($sqlQuery);
                $stmt->execute();

                $fieldHtml = '<select class="form-control main-element updateField" name="lead_source">
                                    <option value="">Select</option>';
                if ($stmt->columnCount() > 0) {
                    $sources = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($sources as $source) {
                        $select = ($source['source_id'] == $source['lead_source']) ? 'selected="selected"' : '';
                        $fieldHtml .= '<option ' . $select . ' value="' . $source['source_id'] . '">' . $source['source_name'] . '</option>';
                    }
                }
                $fieldHtml .= '</select>';
                echo $fieldHtml;
                break;
                    
         }
     
?>
