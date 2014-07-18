<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-status.php';
require_once $include_directory . 'utils-sources.php';
require_once $include_directory . 'utils-call_status.php';

$status = getAllStatus();
$callStatus = getAllCallStatus();
$sources = getAllSources();
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') { ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php removeSessionValue('errorMessage'); } ?>
<div class="container content">
    <div id="main"><div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo BASEPATH; ?>modules/leads/">Leads</a> &raquo; create</h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>

        </div>
        <div class="body">
            <div id="lead-edit" class="edit">
                <form id="form-lead-edit" name="frmCreateLead" id="frmCreateLead" action="<?php echo BASEPATH; ?>modules/leads/new.php" method="POST" >
                    <div class="detail-button-container button-container record-buttons">
                        <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
                        <button type="button" data-action="cancel" class="btn btn-default">Cancel</button>		
                    </div>
                    <div style="height: 21px; display: none;">&nbsp;</div>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group">
                                                <label class="field-label-name control-label">
                                                    Name
                                                    *</label>
                                                <div class="field field-name">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <select class="form-control" name="salutationName">
                                                                <option value=""></option><option value="Mr.">Mr.</option><option value="Mrs.">Mrs.</option><option value="Dr.">Dr.</option><option value="Drs.">Drs.</option>
                                                            </select>		
                                                        </div>
                                                        <div class="col-sm-4">	
                                                            <input type="text" placeholder="First Name" value="" name="firstName" class="form-control">
                                                        </div>
                                                        <div class="col-sm-5">	
                                                            <input type="text" placeholder="Last Name" value="" name="lastName" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="cell cell-accountName  col-sm-6  form-group">
                                                <label class="field-label-accountName control-label">
                                                    Company Name
                                                </label>
                                                <div class="field field-accountName">
                                                    <input type="text" value="" name="accountName" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-emailAddress  col-sm-6  form-group">
                                                <label class="field-label-emailAddress control-label">
                                                    Email
                                                </label>
                                                <div class="field field-emailAddress">
                                                    <input type="email" value="" name="emailAddress" class="main-element form-control"> 
                                                </div>
                                            </div>
                                            
                                            <div class="cell cell-website  col-sm-6  form-group">
                                                <label class="field-label-website control-label">
                                                    Website
                                                </label>
                                                <div class="field field-website">
                                                    <input type="text" value="" name="website" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-title  col-sm-6  form-group">
                                                <label class="field-label-title control-label">
                                                    Title
                                                </label>
                                                <div class="field field-title">
                                                    <input type="text" maxlength="100" value="" name="title" class="main-element form-control">
                                                </div>
                                            </div>
                                            <div class="cell cell-doNotCall  col-sm-6  form-group">
                                                <label class="field-label-doNotCall control-label">
                                                    Do Not Call
                                                </label>
                                                <div class="field field-doNotCall">
                                                    <input type="checkbox" class="main-element" name="doNotCall">
                                                </div>
                                            </div>
                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-address  col-sm-6  form-group">
                                                <label class="field-label-address control-label">
                                                    Address
                                                </label>
                                                <div class="field field-address">
                                                    <input type="text" placeholder="Street" value="" name="addressStreet" class="form-control">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <input type="text" placeholder="City" value="" name="addressCity" class="form-control">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" placeholder="State" value="" name="addressState" class="form-control">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" placeholder="Postal Code" value="" name="addressPostalCode" class="form-control">
                                                        </div>
                                                    </div>
                                                    <input type="text" placeholder="Country" value="" name="addressCountry" class="form-control">
                                                </div>
                                            </div>

                                            <div class="cell cell-phone  col-sm-6  form-group">
                                                <label class="field-label-phone control-label">
                                                    Phone
                                                </label>
                                                <div class="field field-phone">
                                                    <div class="link-container list-group phone-group">
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
                                                <input type="hidden" name="phone" id="phoneCount" value="">
                                            </div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-description  col-sm-6  form-group">
                                                <label class="field-label-description control-label">
                                                    Description
                                                </label>
                                                <div class="field field-description">
                                                    <textarea rows="4" name="description" class="main-element form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6"></div>			
                                        </div>			
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Details</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                        <?php if($status !== NULL && $sources != NULL) :  ?>
                                            <div class="cell cell-status  col-sm-6  form-group">
                                                <label class="field-label-status control-label">
                                                    Status
                                                </label>
                                                <div class="field field-status">
                                                    <select class="form-control main-element" name="status"> 
                                                        <?php foreach ($status as $statusKey => $statusValue) : ?>
                                                                    <option value="<?php echo $statusValue['status_id'];?>"><?php echo $statusValue['status_name'];?></option> 
                                                         <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="cell cell-source  col-sm-6  form-group">
                                                <label class="field-label-source control-label">
                                                    Source
                                                    *</label>
                                                <div class="field field-source">
                                                    <select class="form-control main-element" name="source"> 
                                                        <?php foreach ($sources as $sourceKey => $sourceValue) : ?>
                                                                    <option value="<?php echo $sourceValue['source_id'];?>"><?php echo $sourceValue['source_name'];?></option> 
                                                         <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>			
<div class="row">
                                        <?php if($status !== NULL) :  ?>
                                            <div class="cell cell-status  col-sm-6  form-group">
                                                <label class="field-label-status control-label">
                                                    Call Status
                                                </label>
                                                <div class="field field-status">
                                                    <select class="form-control main-element" name="call_status"> 
                                                        <?php foreach ($callStatus as $statusKey => $statusValue) : ?>
                                                                    <option value="<?php echo $statusValue['status_id'];?>"><?php echo $statusValue['status_name'];?></option> 
                                                         <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="cell cell-source  col-sm-6  form-group">
                                                
                                            </div>
                                            <?php endif; ?>
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
                                                    <input type="text" autocomplete="off" value="<?php echo getSessionValue('firstName') ." ".getSessionValue('lastName');?>" name="assignedUserName" id="assignedUserName" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" type="button" class="btn btn-default selectuser" data-action="singleuser" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                        <button tabindex="-1" type="button" class="btn btn-default user-clear" data-action="singleuser"><i class="glyphicon glyphicon-remove"></i></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" value="<?php echo getSessionValue('user'); ?>" name="assignedUserId" id="assignedUserId">
                                            </div>
                                        </div>

                                        <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                            <label class="control-label label-teams">Teams</label>
                                            <div class="field field-teams">
                                                <div class="link-container list-group team-group">
                                                </div>

                                                <div class="input-group add-team">
                                                    <input type="text" placeholder="Select" autocomplete="off" value="" name="" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" type="button" class="btn btn-default selectteam" data-action="selectLink" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" class="ids" value="" name="teamsIds" id="teamsIds">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>				
                    </div>
            </form>
                </div>
        </div>
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
