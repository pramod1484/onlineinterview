/**
 * 
 * @param {htmlObject} _element
 * @returns {void}
 */
function makeACall(_element) 
{
    var target,res;
    target = BASEPATH+"modules/leads/make-a-call.php";
    $.ajax({
          url:target,
          type:"POST",
          data:{entityId:_element.attr('data-id'),entityType:_element.attr('data-action')},
          dataType:"HTML",
          beforeSend:function() {
          },
          success:function(msg) {
            console.log(msg);
            res = msg;
          },
          complete:function() {
             document.location.href = ('skype:echo123?call'); //+ _element.text() + '?call');
          }
    });      
} 
 
/**
 * Convertion of lead.
 * 
 * @param {integer} lead
 * @returns {void}
 */
function convertLead(lead)
{
    if (confirm('Are you sure. convert this into Opportunity?')) {
        window.location= BASEPATH+'modules/leads/convert.php?id='+lead;
    }
    
    return false;
}

function addPost(updateData) {
    var info = JSON.stringify(updateData);
    $.ajax({
        url: BASEPATH + "common/stream.php",
        type: "POST",
        data: {info: info},
        beforeSend: function() {
            //console.log(info);
        },
        success: function(msg) {
            //console.log(msg); return;
            if (msg.valid == 1 && msg.error != 1) {
                $('.panel-body-stream').children('.list-container').html(msg.html);
                if (msg.message != '') {
                    var successMessage = '<div class="alert alert-success" style="position: fixed; top: 0px; z-index: 2000; left: 640px; overflow: hidden;" id="successMessage">\n\
                                        ' + msg.message + '</div>';
                    $(successMessage).insertAfter($("#header")).fadeOut(4000);
                }
                renderShowMore();
            } else {
                var errorMsg = '';
                if (msg.error == 1 && msg.errorMessage != '') {
                    errorMsg = msg.errorMessage;
                } else if (msg.message != '') {
                    errorMsg = msg.message;
                }
                $('#notification').html(errorMsg).show('fast').fadeOut(4000);
            }

        }
    });
    
}

/**
 * Add Click event to show more button
 * @returns {void}
 */
function renderShowMore () {
    $('.show-more').click(function () { 
        getStream($(this).attr('data-start'));
        $(this).remove();
    });
}

/**
 * Get Stream from start position
 * @param {int} start
 * @returns {void}
 */
function getStream(start) {
    var data = {};
    data['entityId'] = $('#moduleDetail').attr('data-id');
    data['entity'] = $('#moduleDetail').attr('data-module');
    data['start'] = start;
    data['action'] = 'get';
    
    var info = JSON.stringify(data);
    $.ajax({
        url: BASEPATH + "common/stream.php",
        type: "POST",
        data: {info: info},
        beforeSend: function() {
            //console.log(info);
        },
        success: function(msg) {
            if (msg.valid == 1 && msg.error != 1) {
                if (start == 0) {
                    $('.panel-body-stream').children('.list-container').html(msg.html);
                } else {
                    $('.panel-body-stream').children('.list-container').append(msg.html);
                }
                renderShowMore();
                if (msg.message != '') {
                    var successMessage = '<div class="alert alert-success" style="position: fixed; top: 0px; z-index: 2000; left: 640px; overflow: hidden;" id="successMessage">\n\
                                        ' + msg.message + '</div>';
                    $(successMessage).insertAfter($("#header")).fadeOut(4000);
                }
            } else {
                var errorMsg = '';
                if (msg.error == 1 && msg.errorMessage != '') {
                    errorMsg = msg.errorMessage;
                } else if (msg.message != '') {
                    errorMsg = msg.message;
                }
                $('#notification').html(errorMsg).show('fast').fadeOut(4000);
            }

        }
    });
}

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
    $('#postFiles').attr('data-files', assign);
}

/**
 * 
 * @returns {void}
 */
function renderFileUpload() {
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
         $('.panel-body-stream').children('.form-group').append(htm);
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
                                <span class="glyphicon glyphicon-remove"></span>    \n\
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
}

$(function() {
    $(".makeacall").live('click', function () {
        makeACall($(this));
    });

    $(".note").focusin(function() {
        $(this).next('.buttons-panel').removeClass('hide');
    });

    $('.post').click(function() {
        var remark = $('.note').val();
        if (remark == '' && $('#postFiles').length == 0) {
            $('#notification').html('Post can not be empty').show('fast').fadeOut(4000);
        } else {
            var data = {};
            $('.note').prop('disabled', true);
            data['entityId'] = $('#moduleDetail').attr('data-id');
            data['entity'] = $('#moduleDetail').attr('data-module');
            data['remark'] = remark;
            data['action'] = 'add';
            //If Files are attached
            if ($('#postFiles').length > 0) {
                data['files'] = $('#postFiles').attr('data-files');
            }
            //Add post to DB
            addPost(data);
            $(".note").next('.buttons-panel').addClass('hide');
            $(".note").val('');
            $('.note').prop('disabled', false);
            $('#fileDiv').remove();
        }
    });
    
    getStream(0);
    renderFileUpload();
});