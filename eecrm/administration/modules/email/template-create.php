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
?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <h3><a href="<?php echo ADMINPATH; ?>modules/email/template.php">Email Templates</a> &raquo; Create Email Template</h3>
        </div>
        <div class="body"><div class="edit" id="settings-edit">
                <form id="form-settings-edit" method="post" action="<?php echo ADMINPATH; ?>modules/email/template-new.php">
                <div class="detail-button-container button-container record-buttons">
                    <button class="btn btn-primary" data-action="save" type="submit">Save</button>
                    <a type="button" href="<?php echo ADMINPATH; ?>modules/email/template.php" data-action="cancel" class="btn btn-default">Cancel</a>
                </div>
                
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Main</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group">
                                                <label class="field-label-name control-label">
                                                    Name
                                                    *</label>
                                                <div class="field field-name">
                                                    <input type="text" class="main-element form-control" name="name" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="cell cell-subject col-sm-12 form-group">
                                                <label class="field-label-subject control-label">
                                                    Subject
                                                </label>
                                                <div class="field field-subject">

                                                    <input type="text" class="main-element form-control" name="subject" value="">


                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="cell cell-body col-sm-12 form-group">
                                                <label class="field-label-body control-label">
                                                    Body
                                                </label>
                                                <div class="field field-body">
                                                    <link rel="stylesheet" href="<?php echo BASEPATH ?>css/font-awesome.min.css" />
                                                    <link rel="stylesheet" href="<?php echo BASEPATH ?>css/summernote.css">

                                                    <textarea class="main-element form-control summernote" name="body" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">


                                            <div class="cell cell-attachments  col-sm-6  form-group">
                                                <label class="field-label-attachments control-label">
                                                    Attachments
                                                </label>
                                                <div class="field field-attachments">
                                                    <div class="">
                                                        <div>
                                                            <label style="overflow: hidden; width: 50px; cursor: pointer;">
                                                                <span class="btn btn-default" style="cursor: pointer;"><span class="glyphicon glyphicon-paperclip"></span></span>
                                                                <input type="file" name = "files[]" id="fileupload" class="file pull-right" multiple="" style="opacity: 0; width: 1px;">
                                                            </label>
                                                        </div>
                                                        <div class="attachments"></div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="fileIds" id="fileIds">
                                            </div>



                                            <div class="cell cell-isHtml  col-sm-6  form-group">
                                                <label class="field-label-isHtml control-label">
                                                    Is Html
                                                </label>
                                                <div class="field field-isHtml">
                                                    <input type="checkbox" checked="" name="isHtml" class="main-element">

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
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-default">
                                    <div class="row">
                                        <div class="cell cell-assignedUser form-group col-sm-6 col-md-12">
                                            <label class="field-label-assignToUser control-label">
                                                Assigned User *
                                            </label>
                                            <div class="field field-assignToUser">
                                                <div class="input-group">
                                                    <input class="main-element form-control" type="text" name="users" id="users" value="" autocomplete="off">
                                                    <span class="input-group-btn">        
                                                        <button data-action="users" data-type="single" data-toggle="modal" data-target="#myModal" class="btn btn-default selectData" type="button" tabindex="-1"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                        <button data-action="users" data-type="single" class="btn btn-default data-clearLink" type="button" tabindex="-1"><i class="glyphicon glyphicon-remove"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="assignToUserId" id="usersIds" value="">
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
                    <input type="hidden" name="email_template" value="<?php echo $mailDetails['id']; ?>">
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

<script type="text/javascript" src="<?php echo BASEPATH ?>js/summernote.js"></script>
<script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,
        'toolbar': [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
            ]
      });

      $('form').on('submit', function (e) {
        alert($('.summernote').code());
      });
      
      
      $('#fileupload').change(function () {
       if ($('#progress').length > 0) {
            $('#progress').remove();
            var htm = '<div id="progress" class="progress"> \n\
                         <div class="progress-bar progress-bar-success">\n\
                         </div> \n\
                     </div>'; 
            $(htm).insertBefore('#postFiles');
       } else {
            var htm = '<div style="width:50%" id="fileDiv">   \n\
                     <div id="progress" class="progress"> \n\
                         <div class="progress-bar progress-bar-success">\n\
                         </div> \n\
                     </div> \n\
                     <div id="postFiles" data-files="" class="files"></div> \n\
                 </div>';
         $('.attachments').append(htm);
       }
    });
    
    var url = BASEPATH + "common/UploadHandler.php";
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                var html = '<p>' + file.savedName + ' \n\
                            <a href="javascript:" class="delete-record file-clearLink pull-right" data-module="attachment" data-field="id" data-value="' + file.insertId + '" data-id="' + file.insertId + '"> \n\
                                <span class="glyphicon glyphicon-remove"></span>\n\
                            </a></p>';
                
                $(html).appendTo('#postFiles');
                assignFileVal();
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        } 
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


    });
    
/**
 * Search files attached and assign its value
 * @returns {void}
 */
function assignFileVal() {
    var assign = '';
    $('.file-clearLink').each(function () {
       var file = $.trim($(this).attr('data-id'));
       if (assign == '') {
            assign = file;
       } else {
           assign = assign + "," + file;
       }
    });
    $('#fileIds').val(assign);
}
</script>

<script src="<?php echo BASEPATH; ?>js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo BASEPATH; ?>js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo BASEPATH; ?>js/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectList.js"></script>
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectteams.js"></script> 
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
