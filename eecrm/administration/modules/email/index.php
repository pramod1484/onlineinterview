<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-mail.php';

$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') : ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php 
    removeSessionValue('errorMessage'); 
endif;

$mailDetails = getOutboundMailDetails(1);
$isAuth = false;
$isAuth = ($mailDetails['auth']) ? true : false;
$securityArray = array('' => 'Select', 'ssl' => 'SSL', 'tls' => 'TLS');
$hideClass = ($isAuth) ? '' : 'hide';
?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <h3><a href="<?php echo ADMINPATH; ?>">Administration</a> &raquo; Outbound Email</h3>
        </div>
        <div class="body"><div class="edit" id="settings-edit">
                <form id="form-settings-edit" method="post" action="<?php echo ADMINPATH; ?>modules/email/save-outbound.php">
                <div class="detail-button-container button-container record-buttons">
                    <button class="btn btn-primary" data-action="save" type="submit">Save</button>
                    <a type="button" href="<?php echo ADMINPATH; ?>" data-action="cancel" class="btn btn-default">Cancel</a>
                </div>
                
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">SMTP</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-smtpServer  col-sm-6  form-group">
                                                <label class="field-label-smtpServer control-label">
                                                    Server *</label>
                                                <div class="field field-smtpServer">
                                                    <input type="text" class="main-element form-control" name="smtpServer" value="<?php echo $mailDetails['server']; ?>">
                                                </div>
                                            </div>
                                            <div class="cell cell-smtpPort  col-sm-6  form-group">
                                                <label class="field-label-smtpPort control-label">
                                                    Port *</label>
                                                <div class="field field-smtpPort">
                                                    <input type="text" class="main-element form-control" name="smtpPort" value="<?php echo $mailDetails['port']; ?>" pattern="[\-]?[0-9]*" maxlength="4">
                                                </div>
                                            </div>
                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-smtpAuth  col-sm-6  form-group">
                                                <label class="field-label-smtpAuth control-label">
                                                    Auth
                                                </label>
                                                <div class="field field-smtpAuth">
                                                    <input type="checkbox" id="smtpAuth" name="smtpAuth" <?php echo ($isAuth) ? 'checked="checked"' : ''; ?> class="main-element">
                                                </div>
                                            </div>
                                            <div class="cell cell-smtpSecurity  col-sm-6  form-group">
                                                <label class="field-label-smtpSecurity control-label">
                                                    Security
                                                </label>
                                                <div class="field field-smtpSecurity">
                                                    <select name="smtpSecurity" class="form-control main-element">
                                                        <?php echo htmlSelectOptions($securityArray, $mailDetails['security']); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-smtpUsername  col-sm-6  form-group">
                                                <label class="field-label-smtpUsername control-label smtpAuth <?php echo $hideClass; ?>">
                                                    Username
                                                    *</label>
                                                <div class="field field-smtpUsername smtpAuth <?php echo $hideClass; ?>">
                                                    <input type="text" class="main-element form-control" name="smtpUsername" value="<?php echo $mailDetails['username']; ?>">
                                                </div>
                                            </div>
                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-smtpPassword  col-sm-6  form-group">
                                                <label class="field-label-smtpPassword control-label smtpAuth <?php echo $hideClass; ?>">
                                                    Password
                                                </label>
                                                <div class="field field-smtpPassword smtpAuth <?php echo $hideClass; ?>">
                                                    <input type="password" class="main-element form-control" name="smtpPassword" value="<?php echo $mailDetails['password']; ?>">
                                                </div>
                                            </div>
                                        </div>			
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Configuration</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-outboundEmailFromName  col-sm-6  form-group">
                                                <label class="field-label-outboundEmailFromName control-label">
                                                    From Name
                                                    *</label>
                                                <div class="field field-outboundEmailFromName">
                                                    <input type="text" class="main-element form-control" name="outboundFromName" value="<?php echo $mailDetails['from_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="cell cell-outboundEmailFromAddress  col-sm-6  form-group">
                                                <label class="field-label-outboundEmailFromAddress control-label">
                                                    From Address
                                                    *</label>
                                                <div class="field field-outboundEmailFromAddress">
                                                    <input type="text" class="main-element form-control" name="outboundFromAddress" value="<?php echo $mailDetails['from_address']; ?>">
                                                </div>
                                            </div>
                                        </div>		
                                    </div>
                                </div>
                            </div>
                            <div class="extra"></div>
                            <div class="bottom"></div>
                        </div>
                        <div class="side col-md-4">
                        </div>				
                    </div>
                    <input type="hidden" name="email_outbound" value="<?php echo $mailDetails['id']; ?>">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () {
    $('#smtpAuth').change(function () { 
        if ($(this).is(':checked')) {
            $('.smtpAuth').removeClass('hide');
        } else {
            $('.smtpAuth').addClass('hide');
        }
    });
});
</script>
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
