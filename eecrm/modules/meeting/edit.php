<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'utils-meeting.php';
require_once $include_directory . 'utils-entity-teams.php';
if (!empty($_GET['id'])) {
    try {
        $meetingDetails = getMeetingDetails($_GET['id']);

        //Get Teams
        $teams = getTeamNames($_GET['id'], 'Meeting');

        //Get Attendees Users
        $users = getMeetingEntities($_GET['id'], 'User');

        //Get Attendees Leads
        $leads = getMeetingEntities($_GET['id'], 'Lead');
    } catch (Exception $exception) {
        setSessionValue('errorMessage', $exception->getMessage());
    }
}

$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') { ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php removeSessionValue('errorMessage'); } ?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo BASEPATH;?>modules/meeting/">Meetings</a>  &raquo; <?php echo sanitizeString($meetingDetails['name']);?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
       </div>
        
        <div class="body">
            <div class="edit" id="meeting-edit">
                <form id="form-meeting-edit" name="frmEditMeeting" id="frmCreateMeeting" action="<?php echo BASEPATH; ?>modules/meeting/save.php" method="POST">
                <div class="detail-button-container button-container record-buttons">
                    <button class="btn btn-primary" data-action="save" type="submit">Save</button>
                    <a type="button" href="<?php echo BASEPATH; ?>modules/meeting/view.php?id=<?php echo $meetingDetails['id']; ?>" data-action="cancel" class="btn btn-default">Cancel</a>
                </div>
                <div style="height: 21px; display: none;">&nbsp;</div>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Overview</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group">
                                                <label class="field-label-name control-label">Name*</label>
                                                <div class="field field-name">
                                                    <input type="text" class="main-element form-control" name="name" value="<?php echo sanitizeString($meetingDetails['name']); ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="cell cell-parent  col-sm-6  form-group">
                                                <label class="field-label-parent control-label">
                                                    Opportunity
                                                </label>
                                                <div class="field field-parent">
                                                    <div class="row">
                                                        
                                                        <div class="input-group col-sm-6 col-md-12">
                                                            <input class="main-element form-control" type="text" name="opportunity" id="opportunity" value="<?php echo sanitizeString($meetingDetails['oppName']); ?>" autocomplete="off">
                                                            <span class="input-group-btn">        
                                                                <button data-action="opportunity" data-type="single" class="btn btn-default selectData" type="button" tabindex="-1" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                                <button data-action="opportunity" data-type="single" class="btn btn-default data-clear" type="button" tabindex="-1"><i class="glyphicon glyphicon-remove"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="opportunityIds" name="opportunityIds" value="<?php echo sanitizeString($meetingDetails['oppId']); ?>">
                                                </div>
                                            </div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-status  col-sm-6  form-group">
                                                <label class="field-label-status control-label">
                                                    Status
                                                </label>
                                                <div class="field field-status">
                                                    <select name="status" class="form-control main-element">
                                                        <?php echo htmlSelectOptions(meetingCallStatusOption(), $meetingDetails['status']); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6"></div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-dateStart  col-sm-6  form-group">
                                                <label class="field-label-dateStart control-label">
                                                    Date Start*</label>
                                                <div class="field field-dateStart">

                                                    <div class="row">
                                                        <div class="input-group col-lg-6 col-md-6 col-sm-6 date" id="dp1" data-date="<?php echo getFormattedDate($meetingDetails['date_start'], "m/d/Y"); ?>" data-date-format="mm/dd/yyyy">
                                                            <input class="main-element form-control" type="text" name="date_start" value="<?php echo getFormattedDate($meetingDetails['date_start'], "m/d/Y"); ?>" autocomplete="off">
                                                            <span class="input-group-btn add-on">        
                                                                <button type="button" class="btn btn-default" tabindex="-1">
                                                                    <i class="glyphicon glyphicon-calendar icon-calendar"></i>
                                                                </button>    
                                                            </span>
                                                        </div>
                                                        <div class="input-group col-lg-6 col-md-6 col-sm-6">
                                                            <input class="form-control ui-timepicker-input" type="text" id="date_start-time" name="date_start-time" value="<?php echo getFormattedDate($meetingDetails['date_start'], "H:i"); ?>" autocomplete="off">
                                                            <span class="input-group-btn dropdown" >        
                                                                <button type="button" class="btn btn-default" tabindex="-1" id="time1" data-toggle="dropdown">
                                                                    <i class="glyphicon glyphicon-time"></i>
                                                                </button>  
                                                                <ul class="ui-timepicker-list ui-timepicker-wrapper dropdown-menu" data-input="date_start-time" aria-labelledby="time1">
                                                                    <li>00:00</li><li>00:30</li><li>01:00</li><li>01:30</li><li>02:00</li><li>02:30</li><li>03:00</li><li>03:30</li><li>04:00</li><li>04:30</li><li>05:00</li><li>05:30</li><li>06:00</li><li class="">06:30</li><li class="">07:00</li><li>07:30</li><li>08:00</li><li class="">08:30</li><li>09:00</li><li>09:30</li><li class="">10:00</li><li class="ui-timepicker-selected">10:30</li><li>11:00</li><li>11:30</li><li>12:00</li><li>12:30</li><li>13:00</li><li>13:30</li><li>14:00</li><li>14:30</li><li>15:00</li><li>15:30</li><li>16:00</li><li>16:30</li><li>17:00</li><li>17:30</li><li>18:00</li><li>18:30</li><li>19:00</li><li>19:30</li><li>20:00</li><li>20:30</li><li>21:00</li><li>21:30</li><li>22:00</li><li>22:30</li><li>23:00</li><li>23:30</li>
                                                                </ul>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>



                                            <div class="cell cell-dateEnd  col-sm-6  form-group">
                                                <label class="field-label-dateEnd control-label">
                                                    Date End
                                                    *</label>
                                                <div class="field field-dateEnd">

                                                    <div class="row">
                                                        <div class="input-group col-lg-6 col-md-6 col-sm-6 date" id="dp2" data-date="<?php echo getFormattedDate($meetingDetails['date_end'], "m/d/Y"); ?>" data-date-format="mm/dd/yyyy">
                                                            <input class="main-element form-control" type="text" name="date_end" value="<?php echo getFormattedDate($meetingDetails['date_end'], "m/d/Y"); ?>" autocomplete="off">
                                                            <span class="input-group-btn add-on">        
                                                                <button type="button" class="btn btn-default" tabindex="-1">
                                                                    <i class="glyphicon glyphicon-calendar icon-calendar"></i>
                                                                </button>    
                                                            </span>
                                                        </div>
                                                        <div class="input-group col-lg-6 col-md-6 col-sm-6">
                                                            <input class="form-control ui-timepicker-input" type="text" id="date_end-time" name="date_end-time" value="<?php echo getFormattedDate($meetingDetails['date_end'], "H:i"); ?>" autocomplete="off">
                                                            <span class="input-group-btn dropdown">        
                                                                <button type="button" class="btn btn-default" tabindex="-1" id="time2" data-toggle="dropdown">
                                                                    <i class="glyphicon glyphicon-time"></i>
                                                                </button>
                                                                <ul class="ui-timepicker-list ui-timepicker-wrapper dropdown-menu" data-input="date_end-time" aria-labelledby="time2">
                                                                    <li>00:00</li><li>00:30</li><li>01:00</li><li>01:30</li><li>02:00</li><li>02:30</li><li>03:00</li><li>03:30</li><li>04:00</li><li>04:30</li><li>05:00</li><li>05:30</li><li>06:00</li><li class="">06:30</li><li class="">07:00</li><li>07:30</li><li>08:00</li><li class="">08:30</li><li>09:00</li><li>09:30</li><li class="">10:00</li><li class="ui-timepicker-selected">10:30</li><li>11:00</li><li>11:30</li><li>12:00</li><li>12:30</li><li>13:00</li><li>13:30</li><li>14:00</li><li>14:30</li><li>15:00</li><li>15:30</li><li>16:00</li><li>16:30</li><li>17:00</li><li>17:30</li><li>18:00</li><li>18:30</li><li>19:00</li><li>19:30</li><li>20:00</li><li>20:30</li><li>21:00</li><li>21:30</li><li>22:00</li><li>22:30</li><li>23:00</li><li>23:30</li>
                                                                </ul>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-description  col-sm-6  form-group">
                                                <label class="field-label-description control-label">
                                                    Description
                                                </label>
                                                <div class="field field-description">
                                                    <textarea class="main-element form-control" name="description" rows="4"><?php echo sanitizeString($meetingDetails['description']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6"></div>
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
                                                    <input class="main-element form-control" type="text" id="assignedUserName" name="assignedUserName" value="<?php echo sanitizeString($meetingDetails['firstName'])." ".sanitizeString($meetingDetails['lastName']); ?>" autocomplete="off">
                                                    <span class="input-group-btn">        
                                                        <button data-action="singleuser" class="btn btn-default selectuser" type="button" tabindex="-1" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                        <button data-action="clearLink" class="btn btn-default" type="button" tabindex="-1"><i class="glyphicon glyphicon-remove"></i></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" name="assignedUserId" id="assignedUserId" value="<?php echo $meetingDetails['assigned_user_id']; ?>">
                                            </div>
                                        </div>

                                        <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                            <label class="control-label label-teams">Teams</label>
                                            <div class="field field-teams">
                                                <div class="link-container list-group team-group">
                                                <?php
                                                if (count($teams) > 0) :
                                                    $teamIds = array();
                                                    foreach ($teams as $team) :
                                                        $teamIds[] = $team['team_id'];
                                                ?>
                                                        <div class="link-team-<?php echo $team['team_id'] ?> list-group-item"><?php echo $team['teamName'] ?>
                                                                <a data-id="<?php echo $team['team_id'] ?>" class="team-clearLink pull-right" href="javascript:">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </a>
                                                        </div>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>

                                                </div>

                                                <div class="input-group add-team">
                                                    <input class="main-element form-control" type="text" name="" value="" autocomplete="off" placeholder="Select">
                                                    <span class="input-group-btn">        
                                                        <button data-action="selectLink" data-toggle="modal" data-target="#myModal" class="btn btn-default selectteam" type="button" tabindex="-1"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" name="teamsIds" value="<?php echo (isset($teamIds)) ? implode(',', $teamIds) : ''; ?>" class="ids" id="teamsIds">

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="pull-right btn-group">

                                    </div>
                                    <h4 class="panel-title">Attendees</h4>
                                </div>

                                <div class="panel-body panel-body-attendees">
                                    <div class="row">

                                        <div class="cell cell-users form-group col-sm-6 col-md-12">
                                            <label class="control-label label-users">Users</label>
                                            <div class="field field-users">
                                                <div class="link-container list-group list-users">
                                                    <?php
                                                    if (count($users) > 0) :
                                                        $userIds = array();
                                                        foreach ($users as $user) :
                                                            $userIds[] = $user['entityId'];
                                                    ?>
                                                            <div class="link-data-<?php echo $user['entityId']; ?> list-group-item"><?php echo $user['userName']; ?>
                                                                <a data-id="<?php echo $user['entityId']; ?>" data-type="multiple" data-action="users" class="data-clearLink pull-right" href="javascript:">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </a>
                                                            </div>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>

                                                <div class="input-group add-team">
                                                    <input class="main-element form-control" type="text" name="" value="" autocomplete="off" placeholder="Select">
                                                    <span class="input-group-btn">        
                                                        <button data-action="users" data-type="multiple" class="btn btn-default selectData" type="button" tabindex="-1" data-toggle="modal" data-target="#myModal">
                                                            <span class="glyphicon glyphicon-arrow-up"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                                <input type="hidden" id="usersIds" name="usersIds" value="<?php echo (isset($userIds)) ? implode(',', $userIds) : ''; ?>" class="ids">
                                            </div>
                                        </div>

                                        <div class="cell cell-leads form-group col-sm-6 col-md-12">
                                            <label class="control-label label-leads">Leads</label>
                                            <div class="field field-leads">
                                                <div class="link-container list-group list-leads">
                                                    <?php
                                                    if (count($leads) > 0) :
                                                        $leadIds = array();
                                                        foreach ($leads as $lead) :
                                                            $leadIds[] = $lead['entityId'];
                                                    ?>
                                                            <div class="link-data-<?php echo $lead['entityId']; ?> list-group-item"><?php echo $lead['leadName']; ?>
                                                                <a data-id="<?php echo $lead['entityId']; ?>" data-type="multiple" data-action="leads" class="data-clearLink pull-right" href="javascript:">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </a>
                                                            </div>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>

                                                <div class="input-group add-team">
                                                    <input class="main-element form-control" type="text" name="" value="" autocomplete="off" placeholder="Select">
                                                    <span class="input-group-btn">        
                                                        <button data-action="leads" data-type="multiple" class="btn btn-default selectData" type="button" tabindex="-1"  data-toggle="modal" data-target="#myModal">
                                                            <span class="glyphicon glyphicon-arrow-up"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                                <input type="hidden" id="leadsIds" name="leadsIds" value="<?php echo (isset($leadIds)) ? implode(',', $leadIds) : ''; ?>" class="ids">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>				
                    </div>
                <input type="hidden" name="meeting" id="meeting" value="<?php echo $meetingDetails['id']; ?>" />
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
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectList.js"></script>
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(function() {
       var checkin = $('#dp1').datepicker({
          onRender: function(date) {
            //return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          //if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate());
            checkout.setValue(newDate);
          //}
          checkin.hide();
          $('#dp2')[0].focus();
        }).data('datepicker');
        
        var checkout = $('#dp2').datepicker({
          onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
        
        $('.ui-timepicker-list li').click(function () {
            var inputId = $(this).parent('.dropdown-menu').attr('data-input');
            var value = $(this).text();
            $('#' + inputId).val(value);
        });
});
</script>
<?php
require_once dirname(__DIR__) . '/../common/footer.php';
?>