/**
 * This file allow user to select users for different modules.
 */

var forSingleUser;
/**
 * List of teams for selection
 * 
 * @returns {void}
 */
function selectUser() 
{
    var target,res;
    target = BASEPATH + "common/get-users.php";
    $.ajax({
          url:target,
          type:"POST",
          dataType:"HTML",
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
 * Assingning team id to the hidden field so we can receive at server side.
 * 
 * @returns {void}
 */
function assiningUserIds() 
{
        var users = $(".team-clearLink").map(function() {
           return $(this).attr('data-id'); 
        }).get().join(",");

        $("#userIds").val(users);        
}

/**
 * Adding selected team for respective user on document.
 * 
 * @param {integer} teamId
 * @param {string} name
 * @returns {void}
 */
function addUserName(user,name)
{
    if (forSingleUser === 'singleuser') {
        $("#assignedUserName").val(name);
        $("#assignedUserId").val(user);        
    } else {
        var selectedTeams = $("#teamsIds").val().split(",");
        if (selectedTeams.indexOf(teamId.toString()) == '-1') {        
            var str = '<div class="link-team-'+ user +' list-group-item">'+ name +'\n\
                        <a data-id="'+ user +'" class="team-clearLink pull-right" href="javascript:">\n\
                        <span class="glyphicon glyphicon-remove"></span>\n\
                        </a>\n\
                        </div>';

            $(".team-group").append(str);
            assiningUserIds();
        }
    }
    
    $('#myModal').modal('hide');
}

/**
 * Removing team fromt the list
 * 
 * @param {htmlobject} _element
 * @returns {void}
 */
function removeUser(_element) 
{
    if (forSingleUser === 'singleuser') {
        $("#assignedUserName").val('');
        $("#assignedUserId").val('');        
    } else {
        $(".link-team-"+_element.attr('data-id')).remove();
        assiningUserIds();
    }
}

/**
 * Bind events to buttons
 * 
 * @returns {void}
 */
function renderSelectUser() {
    $(".selectuser").click(function() {
       forSingleUser = $(this).attr('data-action');
       selectUser(); 
    });
    
    // Adding users for assigning
    $(".selectusername").live('click', function() {
       var id = $(this).attr('data-id');
       var userName = $(this).html();
       // adding usename
       addUserName(id,userName);
    });
    
    $(".user-clear").live('click',function() {
       forSingleUser = $(this).attr('data-action');
       removeUser($(this)); 
    });
}

$(function() {
    renderSelectUser();
});

