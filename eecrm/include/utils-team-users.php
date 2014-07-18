<?php

require_once 'database.php';

/**
 * Adding user to different teams. 
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return void
 */
function addUsersTeams(Array $teamIds, $userId)
{
    global  $db;
    foreach ($teamIds as $team) {
        $sql = "INSERT INTO `team_users`(
                `id`, `team_id`, `user_id`,`deleted`) VALUES (
                 NULL, '" .$team. "', '" .$userId. "', '0'
                )";
        $statement = $db->prepare($sql);
        $statement->execute();
    }
}

/**
 * Get users teams according to the user id 
 * 
 * @global DB Resource $db
 * @param integer $userId
 */
function getUsersTeamNames($userId) 
{
    global $db;
    try {
        $getTeams = "SELECT tu.id,tu.team_id,t.name AS teamName 
                     FROM team_users AS tu
                     LEFT JOIN teams AS t ON tu.team_id = t.id
                     WHERE tu.user_id = '" .$userId."'  
                     AND tu.deleted = '0'";
        
        $statement = $db->prepare($getTeams);
        $statement->execute();      
        $usersTeams = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return (!empty($usersTeams))? $usersTeams : NULL;
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

/**
 * Updating users team according to the team ids. First removing previous teams
 * and adding new teams again for user.
 * 
 * @param array $teamIds
 * @param integer $user
 * @throws Exception
 */
function updateUsersTeam($teamIds, $user)
{
    global $db;
    try {
        $teams = "DELETE FROM team_users 
                  WHERE user_id = '". $user ."'";
        
        $statement = $db->prepare($teams);
        $statement->execute();      
        addUsersTeams($teamIds,$user);
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }    
}