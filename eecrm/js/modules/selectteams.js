var forDefaultTeam;
/**
 * List of teams for selection
 * 
 * @returns {void}
 */
function selectTeams() 
{
    var target,res;
    target = BASEPATH+"common/get-teams.php";
    
    $.ajax({
          url:target,
          type:"POST",
          dataType:"HTML",
          beforeSend:function() {
          },
          success:function(msg) {
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
function assiningTeamIds() 
{
        var teams = $(".team-clearLink").map(function() {
           return $(this).attr('data-id'); 
        }).get().join(",");

        $("#teamsIds").val(teams);        
}

/**
 * Adding selected team for respective user on document.
 * 
 * @param {integer} teamId
 * @param {string} name
 * @returns {void}
 */
function addTeamName(teamId,name)
{
    
    if (forDefaultTeam === 'defaultTeam') {
        $("#defaultTeamName").val(name);
        $("#defaultTeamId").val(teamId);        
    } else {
        var selectedTeams = $("#teamsIds").val().split(",");
        if (selectedTeams.indexOf(teamId.toString()) == '-1') {
            var str = '<div class="link-team-'+ teamId +' list-group-item">'+ name +'\n\
                        <a data-id="'+ teamId +'" class="team-clearLink pull-right" href="javascript:">\n\
                        <span class="glyphicon glyphicon-remove"></span>\n\
                        </a>\n\
                        </div>';

            $(".team-group").append(str);
            assiningTeamIds();
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
function removeTeam(_element) 
{
    if (forDefaultTeam === 'defaultTeamClear') {
        $("#defaultTeamName").val('');
        $("#defaultTeamId").val('');        
    } else {
        $(".link-team-"+_element.attr('data-id')).remove();
        assiningTeamIds();
    }
}

/**
 * Bind events to buttons
 * 
 * @returns {void}
 */
function renderSelectTeams() {
    $(".selectteam").click(function() {
       forDefaultTeam = $(this).attr('data-action');
       selectTeams(); 
    });
    
    // Adding teams according to the users request.
    $(".selectteamname").live('click', function() {
       var id = $(this).attr('data-id');
       var teamName = $(this).html();
       // adding team name
       addTeamName(id,teamName);
    });
    
    $(".team-clearLink").live('click',function() {
       forDefaultTeam = $(this).attr('data-action');
       removeTeam($(this)); 
    });
}

$(function() {
    renderSelectTeams();
});