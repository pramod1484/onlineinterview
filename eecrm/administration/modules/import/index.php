<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-users.php';

$usersList = getAllUsers(0, MAX_ROWS);
?>
<div class="container content">
    <div id="main"><div class="page-header"><h3><a href="<?php echo ADMINPATH; ?>">Administration</a> &raquo; Import</h3></div>

        <div class="import-container">
            <form name="frmImport" id="frmImport">
            <div class="panel panel-default">
                <div class="panel-heading"><h5 class="panel-title">What to Import?</h5></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="control-label">Entity Type</label>
                            <select class="form-control" name="import-entity-type" id="import-entity-type">				
                                <option value="account">Accounts</option>
                                <option value="Call">Calls</option>
                                <option value="Case">Cases</option>
                                <option value="Contact">Contacts</option>
                                <option value="leads">Leads</option>
                                <option value="Meeting">Meetings</option>
                                <option value="Opportunity">Opportunities</option>
                                <option value="Prospect">Prospects</option>
                                <option value="Task">Tasks</option>
                            </select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="control-label">File</label>
                            <div>
                                <div data-action="next" class="btn btn-primary" id="upload">Upload</div>
                                <span id="status" ></span>
                                <ul id="files" ></ul>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="control-label">What to do?</label>
                            <div>
                                <select id="import-action" class="form-control">
                                    <option value="create">Create Only</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix" style="padding-bottom: 10px;">
                <button type="button" id="importData" data-action="next" class="btn btn-primary pull-right">Import</button>
                <input type="hidden" name="fileName" id="fileName" value="" />
            </div> 
            </form>
        </div>
    </div>
</div>
<script src="<?php echo BASEPATH;?>js/ajaxupload.3.5.js"></script>
<script>
    $(function () {
        
        $("#importData").click(function() {
           var res;
           var fileName = $("#fileName").val();
           var url = "<?php echo ADMINPATH;?>modules/import/import-data.php";
           if (fileName != '') {
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#frmImport").serialize(),
                    dataType:"JSON",
                    beforeSend:function() {
                        $('body').append('<div class="modal-backdrop fade in">\n\
                                                        <center><div class="alert alert-info" id="notification">\n\
                                                        <strong id="saveuser" class="icon-download-alt">&nbsp;</strong> Loading....</div>\n\
                                                        </center>\n\
                                                    </div>');                         
                    },
                    success:function(msg) {
                        $("#notification").html('<strong id="saveuser" >&nbsp;</strong> Loading....');
                        res = msg;
                    },
                    complete: function () {
                        if (res.valid == 1) {
                            $("#notification").html('<strong id="saveuser" >&nbsp;</strong> Data Added');
                            $(".modal-backdrop").remove();
                        } else {
                            $("#notification").html('<strong id="saveuser" >&nbsp;</strong>'+ res.str);
                        }
                    }
                });
           }
        });
        // For ajax upload
        var uploadBtn = $("#upload");
        var status = $("#status");
        new AjaxUpload(uploadBtn, {
                // Arquivo que fará o upload
                action: BASEPATH+'common/upload-file.php',
                //Nome da caixa de entrada do arquivo
                name: 'uploadfile',
                onSubmit: function(file, ext){
        //             if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
        //                // verificar a extensão de arquivo válido
        //                status.text('Somente JPG, PNG ou GIF são permitidas');
        //                return false;
        //            }
                    status.text('Enviando...');
                },
                onComplete: function(file, response){
                    $("#fileName").val(file);
                    //Limpamos o status
                    status.text('');
                    //Adicionar arquivo carregado na lista
                    if(response==="success"){
                        $('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
                    } else{
                        $('<li></li>').appendTo('#files').text(file).addClass('error');
                    }
                }
            });          
    });
</script>
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
