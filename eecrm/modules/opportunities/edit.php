<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-opportunities.php';
require_once $include_directory . 'utils-entity-teams.php';
require_once $include_directory . 'utils-stages.php';
require_once $include_directory . 'utils-sources.php';
require_once $include_directory . 'utils-call_status.php';

if (!empty($_GET['id'])) {
    try {
        $oppotunityDetails = getOpportunityDetails($_GET['id']);
        $_SESSION['opportunity_stage'] = $oppotunityDetails['stage'];
        $_SESSION['opportunity_call_status'] = $oppotunityDetails['call_status'];
        $_SESSION['opportunity_assigned_user'] = $oppotunityDetails['assigned_user_id'];
        $opportunityTeams = getTeamNames($_GET['id'],'Opportunity');
        $oppPhones = getOpportunityPhones($_GET['id']);
        
    } catch (Exception $exception) {
        setSessionValue('errorMessage', $exception->getMessage());
    }

    $sources = getAllSources();
    $stages = getOpportunitiesStages();
    $callStatus = getAllCallStatus();
}
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') {
    ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
    <?php echo $errorMessage; ?>
    </div>
    <?php removeSessionValue('errorMessage');
} ?>

<div class="container content">
    <div id="main">
      <form id="frmEditOpportunity" name="frmEditOpportunity" action="<?php echo BASEPATH?>modules/opportunities/save.php" method="POST">        
        <div class="page-header">
            <h3><a href="<?php echo BASEPATH?>modules/opportunities">Opportunities</a>
                &raquo;
                <a href="<?php echo BASEPATH?>modules/opportunities/view.php?id=<?php echo $oppotunityDetails['id'];?>"><?php echo sanitizeString($oppotunityDetails['contact_person']);?></a>
            </h3>
        </div>
        <div class="detail-button-container button-container record-buttons">
            <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
            <a type="button" href="<?php echo BASEPATH; ?>modules/opportunities/view.php?id=<?php echo $_GET['id'];?>" data-action="cancel" class="btn btn-default">Cancel</a>		
        </div>          
        <div>
            <div class="edit-container-opportunity">
                <div id="opportunity-edit" class="edit">
                        <div class="row">
                            <div class=" col-md-8">
                                <div class="record">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="cell cell-name  col-sm-6  form-group">
                                                    <label class="field-label-name control-label">
                                                        Company Name
                                                        *</label>
                                                    <div class="field field-name">
                                                        <input type="text" value="<?php echo sanitizeString($oppotunityDetails['company_name']);?>" name="company_name" class="main-element form-control" data-original-title="" title="">
                                                    </div>
                                                </div>
                                              <div class="cell cell-name  col-sm-6  form-group">
                                                    <label class="field-label-name control-label">
                                                        Contact Person
                                                        *</label>
                                                    <div class="field field-name">
                                                        <input type="text" value="<?php echo sanitizeString($oppotunityDetails['contact_person'])?>" name="name" class="main-element form-control" />
                                                    </div>
                                                </div>                                                
                                        </div>
                                                                                    
                                        <div class="row">
                                            <div class="cell cell-emailAddress  col-sm-6  form-group">
                                                <label class="field-label-emailAddress control-label">
                                                    Email
                                                *</label>
                                                <div class="field field-emailAddress">
                                                    <input type="email" value="<?php echo $oppotunityDetails['email_address'];?>" name="emailAddress" class="main-element form-control"> 
                                                </div>
                                            </div>
                                            
                                            <div class="cell cell-website  col-sm-6  form-group">
                                                <label class="field-label-website control-label">
                                                    Website
                                                </label>
                                                <div class="field field-website">
                                                    <input type="text" value="<?php echo $oppotunityDetails['website'];?>" name="website" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>	                                            
                                            <div class="row">
                                            <div class="cell cell-address  col-sm-6  form-group">
                                                <label class="field-label-address control-label">
                                                    Address
                                                </label>
                                                <div class="field field-address">
                                                    <input type="text" placeholder="Street" value="<?php echo sanitizeString($oppotunityDetails['address_street']);?>" name="addressStreet" class="form-control">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <input type="text" placeholder="City" value="<?php echo sanitizeString($oppotunityDetails['address_city']);?>" name="addressCity" class="form-control">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" placeholder="State" value="<?php echo sanitizeString($oppotunityDetails['address_state']);?>" name="addressState" class="form-control">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" placeholder="Postal Code" value="<?php echo sanitizeString($oppotunityDetails['address_postal_code']);?>" name="addressPostalCode" class="form-control">
                                                        </div>
                                                    </div>
                                                    <input type="text" placeholder="Country" value="<?php echo sanitizeString($oppotunityDetails['address_country'])?>" name="addressCountry" class="form-control">
                                                </div>
                                            </div>

                                            <div class="cell cell-phone  col-sm-6  form-group">
                                                <label class="field-label-phone control-label">
                                                    Phone
                                                </label>
                                                <div class="field field-phone">
                                                    <div class="link-container list-group phone-group">
                                                    <?php 
                                                    $phones = array();
                                                    if (count($oppPhones) > 0) :
                                                        foreach ($oppPhones as $phone) :
                                                            $phones[] = $phone['phone'];
                                                        ?>
                                                        <div class="link-phone list-group-item"><?php echo $phone['phone'] ?>
                                                            <a class="phone-clearLink pull-right" href="javascript:">
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                            </a>
                                                        </div>
                                                   <?php
                                                        endforeach;
                                                   endif;
                                                   ?>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" maxlength="20" id="phoneVal" name="phoneVal" placeholder="Enter Phone" class="main-element form-control">
                                                        <span class="input-group-btn">        
                                                            <button tabindex="-1" type="button" class="btn btn-default addPhone">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="phone" id="phoneCount" value="<?php echo (count($phones) > 0) ? implode(',', $phones) : ''; ?>">
                                            </div>
                                        </div>		
                                            <div class="row">
                                                <div class="cell cell-description  col-sm-6  form-group">
                                                    <label class="field-label-description control-label">
                                                        Remarks
                                                    </label>
                                                    <div class="field convertfield-description form-group">
                                                        <textarea rows="4" cols="10" name="description" class="note form-control"><?php echo sanitizeString($oppotunityDetails['description']);?></textarea>
                                                    </div>
                                                </div>                                                

                                                <div class="col-sm-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                <div class="panel-heading"><h4 class="panel-title">Details</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                                <div class="cell cell-stage  col-sm-6  form-group">
                                                    <label class="field-label-stage control-label">
                                                        Stage
                                                    *</label>
                                                    <div class="field field-stage">
                                                        <select class="form-control main-element" name="stage" id="stage">
                                                            <option value="">Select</option>
                                                            <?php if (count($stages) > 0):  
                                                                foreach ($stages as $stage): ?>
                                                                    <option  value="<?php echo $stage['stage_id'];?>" <?php if ($oppotunityDetails['stage'] == $stage['stage_id']): ?> selected="selected" <?php endif;?>>
                                                                        <?php echo sanitizeString($stage['stage_name']);?>
                                                                    </option>
                                                                <?php endforeach;
                                                                endif;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="cell cell-source  col-sm-6  form-group">
                                                <label class="field-label-source control-label">
                                                    Lead Source
                                                    *</label>
                                                <div class="field field-source">
                                                    <select class="form-control main-element" name="source"> 
                                                        <option value="">Select</option>
                                                        <?php foreach ($sources as $sourceKey => $sourceValue) : ?>
                                                                    <option value="<?php echo $sourceValue['source_id'];?>" <?php if ($oppotunityDetails['lead_source'] == $sourceValue['source_id']): ?> selected="selected" <?php endif;?>>
                                                                        <?php echo $sourceValue['source_name'];?>
                                                                    </option> 
                                                         <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>                                          
                                            </div>    			
                                    <div class="row">
                                        <div class="cell cell-stage  col-sm-6  form-group">
                                                    <label class="field-label-stage control-label">
                                                        Call Status
                                                    *</label>
                                                    <div class="field field-stage">
                                                       <select class="form-control main-element" name="call_status"> 
                                                        <?php foreach ($callStatus as $statusKey => $statusValue) : ?>
                                                                    <option value="<?php echo $statusValue['status_id'];?>" <?php if ($oppotunityDetails['call_status'] == $statusValue['status_id']): ?> selected="selected" <?php endif;?>><?php echo $statusValue['status_name'];?></option> 
                                                         <?php endforeach; ?>
                                                    </select>
                                                    </div>
                                                </div>

                                    </div>
                                </div>
                            </div>
                                <div class="extra"></div>
                                <div class="bottom"></div>
                            </div>
                                                    <div class="side col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-default">
                                    <div class="row">
                                        <div class="cell cell-assignedUser form-group col-sm-6 col-md-12">
                                            <label class="control-label label-assignedUser">Assigned User *</label>
                                            <div class="field field-assignedUser">
                                                <div class="input-group">
                                                    <input type="text" autocomplete="off" value="<?php echo $oppotunityDetails['firstName'] ." ".$oppotunityDetails['lastName'];?>" name="assignedUserName" id="assignedUserName" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" type="button" class="btn btn-default selectuser" data-action="singleuser" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                        <button tabindex="-1" type="button" class="btn btn-default user-clear" data-action="singleuser"><i class="glyphicon glyphicon-remove"></i></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" value="<?php echo $oppotunityDetails['assigned_user_id']; ?>" name="assignedUserId" id="assignedUserId">
                                            </div>
                                        </div>
                                        
                                        <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                            <label class="control-label label-teams">Teams</label>
                                            <div class="field field-teams">
                                                <div class="link-container list-group team-group">
                                                    <?php if (count($opportunityTeams) > 0): 
                                                              foreach ($opportunityTeams as $opportunityTeam) : ?>
                                                                <div class="link-team-<?php echo $opportunityTeam['team_id'];?> list-group-item">
                                                                    <?php echo sanitizeString($opportunityTeam['teamName']);?>
                                                                    <a href="javascript:" class="team-clearLink pull-right" data-id="<?php echo $opportunityTeam['team_id'];?>">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                    </a>
                                                                </div>
                                                    <?php endforeach; 
                                                    endif; ?>
                                                </div>

                                                <div class="input-group add-team">
                                                    <input type="text" placeholder="Select" autocomplete="off" value="" name="" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" type="button" class="btn btn-default selectteam" data-action="selectLink" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" class="ids" value="<?php echo implode(",", array_map(function($arr){ return $arr['team_id'];}, $opportunityTeams));?>" name="teamsIds" id="teamsIds">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>	
                        </div>
                </div>
            </div>
        </div>
          <input type="hidden" name="opportunity_id" id="opportunity_id" value="<?php echo $_GET['id'];?>"/>
          <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $oppotunityDetails['lead_id'];?>"/>
        </form>
    </div>
</div>

<!-- to create and open modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="userModalLable" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectuser.js"></script>        
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectteams.js"></script>        
<?php
require_once dirname(__DIR__) . '/../common/footer.php';
?>