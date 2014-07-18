/* 
 * Inline Editing of fields on view pages of Leads/Opportunity/Meetings etc.
 * 
 */


/**
 * All necessary functions that should initialize during the documet loading.
 * 
 * @returns {void}
 */

$(document).ready(function () {
    renderEditLink();
    $('.inline-edit-link').click(function () {
        $( ".inline-cancel-link" ).trigger( "click" );
        renderCancelLink(this);
        
    });
});

/**
 * Render Hover effect for edit link
 * 
 * @returns {void}
 */
function renderEditLink() {
    $('.cell').hover(
        function() { 
            if ($(this).children('.inline-cancel-link').length == 0) {
                    $(this).children('.inline-edit-link').removeClass('hide')
            }
        },
        function(){ $(this).children('.inline-edit-link').addClass('hide') }
    );
}

/**
 * Add Update And Cancel Link
 * @param {htmlobject} editLink Edit link html object
 * @returns {void}
 */
function renderCancelLink(editLink) {
    $(editLink).addClass('hide');
    var cancelHtml = '<a href="javascript:" class="pull-right inline-cancel-link" style="margin-left: 8px;">Cancel</a>\n\
                   <a href="javascript:" class="pull-right inline-save-link">Update</a>';
    $(cancelHtml).insertBefore(editLink);
    
    var fieldType = $(editLink).attr('data-field-type');
    var fieldName = $(editLink).attr('data-field');
    var field = $(editLink).parent('.cell').children('.field');
    var fieldVal = $(field).html();
    var module = $('#moduleDetail').attr('data-module');
    var id = $('#moduleDetail').attr('data-id');
    var replaceHtmlData = '';
    
    if (fieldType == '') {
        addAjaxField(field, fieldName, module, id);
    } else if (fieldType == 'replaceHtml') {
        replaceHtmlData = replaceHtml(field, editLink);
    } else {
        addField(field, fieldType, fieldName, module);
    }
    
    $('.inline-cancel-link').click(function () {
        $(this).parent('.cell').children('.inline-save-link').remove();
        
        if (replaceHtmlData != '') {
            assiningUserIds();
            assiningTeamIds();
            
            //This must be called after assigning Ids
            $(this).parent('.cell').children('.replaceHtml').html(replaceHtmlData);
        }
        $(this).remove();
        if (fieldType == 'phone') {
            $('#phoneCount').val($(fieldVal).text());
        }
        
        $(field).html(fieldVal);
    });
    
    $('.inline-save-link').click(function () {
        var data = {};
        if (fieldType == 'enable') {
            var inputField = $(field).children('input');
            if ($(inputField).attr('type') == 'checkbox') {
                setCheckBox(inputField, $(inputField).attr('data-field'), $(inputField).attr('data-uncheck'), $(inputField).attr('data-check'));
            }
        }
        if (fieldType == 'phone') {
            assignPhoneVal();
            var phoneVal = $('#phoneVal').val();
            if (validatePhone(phoneVal)) {
                var updateVal = $('#phoneCount').val();
                if (updateVal == '') {
                    $('#phoneCount').val($.trim(phoneVal));
                } else {
                    $('#phoneCount').val(updateVal + ',' +$.trim(phoneVal));
                }
            } else if (phoneVal != '') {
                $('#phoneVal').val('');
                $('#phoneVal').attr('placeholder', 'Enter Valid Phone');
                return false;
            }
        }
        
        $(this).parent('.cell').find('.updateField').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });
        //console.log(data);
        updateData(data, module, id, field, fieldVal, fieldType);
        if (replaceHtmlData != '') {
            assiningUserIds();
            assiningTeamIds();
            
            //This must be called after assigning Ids
            $(this).parent('.cell').children('.replaceHtml').html(replaceHtmlData);
        }
        
    });
}


/**
 * Get field html by ajax
 * @param {htmlobject} field Element to add field html
 * @param {string} fieldName 
 * @param {string} module entity ex. leads, meetings etc
 * @param {string} id id of entity
 * @returns {void}
 */
function addAjaxField(field, fieldName, module, id) {
    $.ajax({
        type: "POST",
        url: BASEPATH + 'common/inlineHtml.php',
        data: 'module=' + module + '&id=' + id + '&field=' + fieldName,
        beforeSend: function() {

        },
        success: function(data) {
            //alert(data);
            $(field).html(data);
        }
    });
}

/**
 * Add field by its type
 * @param {htmlobject} field Element to add field
 * @param {string} fieldType Type of the field
 * @param {string} fieldName Name of the field
 * @returns {void}
 */
function addField(field, fieldType, fieldName, module) {
    var html = '';
    switch (fieldType) {
        case 'text' :
            html = '<input type="text" class="main-element form-control updateField" name="' + fieldName + '" value="' + $.trim($(field).text()) + '">';
            break;
        case 'textarea' :
            html = '<textarea rows="4" name="' + fieldName + '" class="main-element form-control updateField">' + $.trim($(field).text()) + '</textarea>';
            break;
        case 'enable' :
            $(field).children('input').removeAttr('disabled');
            return;
            break;
        case 'phone' :
            var phoneArr = $('#phoneCount').val().split(',');
            //alert(phoneArr.length);
            var phonesHtml = '';
            if ($.isArray(phoneArr) && phoneArr.length > 0) {
                $.map(phoneArr, function(val) {
                    if (val != '') {
                        phonesHtml += '\n<div class="link-phone list-group-item">' + val + '\n\
                                            <a class="phone-clearLink pull-right" href="javascript:">   \n\
                                                <span class="glyphicon glyphicon-remove"></span>\n\
                                            </a>    \n\
                                        </div>';
                    }
                });
            }
            html = '<div class="link-container list-group phone-group"> \n\
                        ' + phonesHtml + '\n\
                    </div>  \n\
                    <div class="input-group">     \n\
                        <input type="text" maxlength="20" id="phoneVal" name="phoneVal" placeholder="Enter Phone" class="main-element form-control">    \n\
                        <span class="input-group-btn">  \n\
                            <button tabindex="-1" type="button" class="btn btn-default addPhone">   \n\
                                <span class="glyphicon glyphicon-plus"></span>  \n\
                            </button>   \n\
                        </span> \n\
                    </div>';

            break;


    }
    $(field).html(html);
    if (fieldType == 'phone') {
        renderPhone();
    }
}

/**
 * Replace hidden html of update form and return replaced html
 * @param {htmlobject} field Element to add html
 * @param {htmlobject} editLink
 * @returns {string}
 */
function replaceHtml(field, editLink) {
    var replaceField = $(editLink).parent('.cell').children('.replaceHtml');
    var htmlData = $(replaceField).html();
    $(field).html(htmlData);
    $(replaceField).html('');
    renderSelectUser();
    renderSelectTeams();
    return htmlData;
}

/**
 * 
 * @param {type} updateData
 * @param {type} module
 * @param {type} id
 * @param {type} field
 * @param {type} fieldVal
 * @param {type} fieldType
 * @returns {void}
 */
function updateData(updateData, module, id, field, fieldVal, fieldType) {
    var info = JSON.stringify(updateData);
    $.ajax({
        url: BASEPATH + "common/updateInline.php",
        type: "POST",
        dataType: "json",
        data: {info: info, module: module, id: id},
        beforeSend: function() {
            //console.log(info);
        },
        success: function(msg) {
            //console.log('\nmsg: ' + msg);
            $(field).parent('.cell').children('.inline-save-link').remove();
            $(field).parent('.cell').children('.inline-cancel-link').remove();
            if (msg.valid == 1 && msg.error != 1) {
                $(field).html(msg.html);
                $('#modifiedAt').html(msg.modifiedAt);
                if (msg.message != '') {
                    var successMessage = '<div class="alert alert-success" style="position: fixed; top: 0px; z-index: 2000; left: 640px; overflow: hidden;" id="successMessage">\n\
                                        ' + msg.message + '</div>';
                    $(successMessage).insertAfter($("#header")).fadeOut(4000);
                }
                if (msg.stream == 1) {
                    getStream(0);
                }
            } else {
                var errorMsg = '';
                if (msg.error == 1 && msg.errorMessage != '') {
                    errorMsg = msg.errorMessage;
                } else if (msg.message != '') {
                    errorMsg = msg.message;
                }
                $('.notification').html(errorMsg).show('fast').fadeOut(4000);
                $(field).html(fieldVal);
            }

            if (fieldType == 'enable') {
                $(field).children('input').prop('disabled', true);
            }
        }
    });
}

/**
 * 
 * @param {type} checkBox
 * @param {type} setField
 * @param {type} uncheck
 * @param {type} check
 * @returns {void}
 */
function setCheckBox(checkBox, setField, uncheck, check) {
    if ($(checkBox).is(':checked')) {
        $('#' + setField).val(check);
    } else {
        $('#' + setField).val(uncheck);
    }
}