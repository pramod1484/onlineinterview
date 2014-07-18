/**
 * This file allow user to select data for different modules.
 */

var forData;
var dataType;
/**
 * List of Data for selection
 * 
 * @returns {void}
 */
function selectData() 
{
    var target,res;
    target = BASEPATH + "common/get-data.php";
    $.ajax({
          url:target,
          type:"POST",
          data: {forData: forData},
          beforeSend:function() {
          },
          success:function(msg) {
            //alert(msg);
            res = msg;
          },
          complete:function() {
            $(".modal-content").html(res);
          }
    });      
} 

/**
 * Assingning Data id to the hidden field so we can receive at server side.
 * 
 * @returns {void}
 */
function assiningDataIds() 
{
        //console.log($('.list-' + forData + ' .list-group-item').children(".data-clearLink").attr('data-id'));
        var ids = $('.list-' + forData + ' .list-group-item').children(".data-clearLink").map(function() {
           return $(this).attr('data-id'); 
        }).get().join(",");

        $("#" + forData + "Ids").val(ids);        
}

/**
 * Adding selected data for respective user on document.
 * 
 * @param {integer} data id
 * @param {string} data name
 * @returns {void}
 */
function addDataValue(id, value)
{
    if (dataType == 'single') {
        $("#" + forData).val(value);
        $("#" + forData + "Ids").val(id);
    } else {
        var selectedValues = $("#" + forData + "Ids").val().split(",");
        if (selectedValues.indexOf(id.toString()) == '-1') {
            var str = '<div class="link-data-' + id + ' list-group-item">' + value + '\n\
                            <a data-id="' + id + '" data-type="' + dataType + '" data-action="' + forData + '" class="data-clearLink pull-right" href="javascript:">\n\
                            <span class="glyphicon glyphicon-remove"></span>\n\
                            </a>\n\
                            </div>';

            $(".list-" + forData).append(str);
            assiningDataIds();
        }
    }

    $('#myModal').modal('hide');
}

/**
 * Removing data fromt the list
 * 
 * @param {htmlobject} _element
 * @returns {void}
 */
function removeData(_element) {
    if (dataType == 'single') {
        $("#" + forData).val('');
        $("#" + forData + "Ids").val('');
    } else {
        $(".link-data-"+_element.attr('data-id')).remove();
        assiningDataIds();
    }
}

/**
 * Bind events to buttons
 * 
 * @returns {void}
 */
function renderSelect() {
    $(".selectData").click(function() {
       forData = $(this).attr('data-action');
       dataType = $(this).attr('data-type');
       selectData(); 
    });
    
    // Adding Data for assigning
    $(".selectDataValue").live('click', function() {
       var id = $(this).attr('data-id');
       var value = $.trim($(this).text());
       // adding Value
       addDataValue(id, value);
    });
    
    $(".data-clearLink").live('click',function() {
       forData = $(this).attr('data-action');
       dataType = $(this).attr('data-type');
       
       removeData($(this)); 
    });
}

$(function() {
    renderSelect();
});

