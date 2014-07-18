/**
 * Deleting record.
 * 
 * @param {htmlobject} _element
 * @returns {void}.
 */
function deleteRecord(_element) {
    var module  = _element.attr('data-module');
    var field   = _element.attr('data-field');
    var value   = _element.attr('data-value');
    var isAdmin = _element.attr('data-isadmin');
    $.ajax({
          url:BASEPATH+"common/delete-record.php",
          type:"POST",
          data:{module:module, field:field, value:value, isAdmin:isAdmin},
          dataType:"JSON",
          beforeSend:function() {
            $("#notification").html('<strong id="saveuser" >&nbsp;</strong> Loading....');
          },
          success:function(msg) {
            if(msg.valid) {
                
                 var redirectUrl = 'modules/'+module+'/';
                 if (isAdmin == '1') {
                     if (module == 'email_outbound') {
                         module = 'email';
                     } else if (module == 'email_inbound') {
                         module = 'email/inbound.php';
                     }
                     redirectUrl = 'administration/modules/'+module;
                 }
                 
                 //If module is not attachment redirecting user to different location
                 if (module != 'attachment') {
                    redirect(redirectUrl);
                 } else {
                     _element.parent('p').remove();
                     assignFileVal();
                 }
             } else {
                 // if fail to delete the record.
             }
          }
    });    
}

/**
 * Remove multiple records 
 * 
 * @param {htmlobject} _element
 * @returns {void}.
 */
function deleteMultipleRecords(_element) {
    var module  = _element.attr('data-module');
    var field   = _element.attr('data-field');
    var isAdmin = _element.attr('data-isadmin');
    
    var rowIds = $(".records-multiaction").map(function () {
        return $(this).attr('data-id');
    }).get();
    $.ajax({
          url:BASEPATH+"common/delete-record-multiple.php",
          type:"POST",
          data:{module:module,field:field,value:rowIds,isAdmin:isAdmin},
          dataType:"JSON",
          beforeSend:function() {
            $("#notification").html('<strong id="saveuser" >&nbsp;</strong> Loading....');
          },
          success:function(msg) {
            //console.log(msg);
            if(msg.valid) {
                 var redirectUrl = 'modules/'+module+'/';
                 if (isAdmin == '1') {
                     redirectUrl = 'administration/modules/'+module+'/';
                 }
                 // redirecting user to different location
                 redirect(redirectUrl);
             } else {
                 // if fail to delete the record.
             }
          }
    });    
}

/**
 * Searching record according to the users entered search string
 * 
 * @param {htmlobject} _element
 * @returns {void}
 */
function searchRecord(_element) 
{
    var searchString = $("input[name='filter']").val();
    var module = $(_element).attr('data-module');
    var isAdmin = $(_element).attr('data-isadmin');
    var mineOnly = $("#onlyMy").is(":checked");
    var target;
    if (isAdmin == '1') {
        target = BASEPATH+"administration/modules/"+ module +"/record-search.php";
    } else {
        target = BASEPATH+"modules/"+ module +"/record-search.php";
    }
    
    $.ajax({
          url:target,
          type:"POST",
          data:{module:module,search:searchString,isAdmin:isAdmin,mine:mineOnly},
          dataType:"JSON",
          beforeSend:function() {
            $('body').append('<div class="modal-backdrop fade in">\n\
                                <center><div class="alert alert-info" id="notification">\n\
                                <strong id="saveuser" class="icon-download-alt">&nbsp;</strong> Loading....</div>\n\
                                </center>\n\
                            </div>');                  
            $("#notification").html('<strong id="saveuser" >&nbsp;</strong> Loading....');
          },
          success:function(msg) {
            $("#notification").html('<strong id="saveuser" >&nbsp;</strong> Searching....');
            res = msg;
          },
          complete:function() {
             if(res.valid) {
                 $("tr.initial").hide();
                 $("tr.search-res").remove();
                 $("tr.initial:last").after(res.str);
             } else {
                 $("tr.initial").hide();
                 $("tr.search-res").remove();
                 $("tr.initial:last").after(res.str);
             }
             $(".modal-backdrop").remove();
          }
    });     
}

/**
 * Reseting the search filter.
 * 
 * @returns {void}
 */
function resetRecord() 
{
    $("tr.search-res").remove();
    $("tr.initial").show();
    $(".filter").val('');
    
}

/**
 * Function to redirect user to another location
 *  
 * @param {string} location 
 */
function redirect(location) 
{
    window.location = BASEPATH+location;
}

/**
 * Enabling or disabling action button selection box above the records.
 * 
 * @param {bool} isChecked
 * @returns {void}
 */
function enableActionButton(isChecked) 
{
    if (isChecked) {
        $(".actions-button").removeAttr("disabled"); 
    } else {
        $(".actions-button").attr("disabled","disabled"); 
    }    
}

/**
 * Add Phone Number html div 
 * @returns {void}
 */
function addPhone() {
   var phoneVal = $('#phoneVal').val();
   var phoneCount = $("#phoneCount").val().split(",");
   if (phoneVal != '') {
            if (validatePhone(phoneVal) && phoneCount.indexOf(phoneVal) == '-1') {
                var str = '<div class="link-phone list-group-item">'+ phoneVal +'\n\
                                 <a class="phone-clearLink pull-right" href="javascript:">\n\
                                 <span class="glyphicon glyphicon-remove"></span>\n\
                                 </a>\n\
                           </div>';
                $(".phone-group").append(str);
                $('#phoneVal').val('');
                assignPhoneVal();
                renderPhone();
            } else {
                $('#phoneVal').val('');
                $('#phoneVal').attr('placeholder', 'Enter Valid Phone');
            }
       }
}

/**
 * Return false if phone number is not digit or + or - sign and less than 5 
 * @param {string} txtPhone
 * @returns {Boolean}
 */
function validatePhone(txtPhone) {
    var filter = /^[0-9-+]+$/;
    //alert(txtPhone.length);
    if (filter.test(txtPhone) && txtPhone.length > 5) {
        return true;
    }
    else {
        return false;
    }
}

/**
 * Assign added Phone Values to hidden field
 * @returns {void}
 */
function assignPhoneVal() {
    var assign = '';
    $('.link-phone').each(function () {
       var phone = $.trim($(this).text());
       if (assign == '') {
            assign = phone;
       } else {
           assign = assign + "," + phone;
       }
    });
    $('#phoneCount').val(assign);
}

/**
 * Render Click Event for add and remove phone button
 * @returns {void}
 */
function renderPhone() {
   $('.addPhone').click(function () { 
       addPhone();
   });
   
   $('.phone-clearLink').click(function () {
        $(this).parent('.link-phone').remove();
        assignPhoneVal();
   });
}

/**
 * All necessary functions that should initialize during the documet loading.
 * 
 * @returns {void}
 */
$(function() {
   // for deleting resepectiv record;
   $('.delete-record').live('click', function () {
       if ($(this).attr('data-module') == 'attachment') {
            deleteRecord($(this));

        } else if (confirm('Are you sure do you want to delete the record')) {
            $('body').append('<div class="modal-backdrop fade in">\n\
                                     <center><div class="alert alert-info" id="notification">\n\
                                     <strong id="saveuser" class="icon-download-alt">&nbsp;</strong> Loading....</div>\n\
                                     </center>\n\
                                 </div>');
           deleteRecord($(this));
        }
   });
   
   // for mass remove records 
   $(".massremove").click(function() {
       deleteMultipleRecords($(this));
   });
   
   // when user clicks on any check box from the record list
   $(".records-multiaction").click(function() {
      var isChecked = $(this).is(":checked");
      enableActionButton(isChecked);
   });
   // selecting all checkboxes from the record list.
   $(".selectAll").click(function() {
      var selfChecked = $(this).is(":checked"); 
      if (selfChecked) {
          $(".records-multiaction").attr('checked','checked');
      } else {
          $(".records-multiaction").removeAttr('checked');
      }
      
      enableActionButton(selfChecked);
   });
   
   // when user searches a record using the search box.
   $(".search").click(function () {
       searchRecord($(this));
   });
   
   // reseting search filter to empty string
   $(".resetrecord").click(function () {
       resetRecord();
   });
   
   renderPhone();
});

