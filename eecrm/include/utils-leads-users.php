<?php

/**
 * This file will contains the function related to the leads team.
 * 
 */

require_once 'database.php';

/**
 * Adding leads to different teams. 
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return void
 */
function addLeadsTeams(Array $teamIds, $leadId)
{
    global  $db;
     try {
        foreach ($teamIds as $team) {
            $sql = "INSERT INTO `team_leads`(
                    `id`, `team_id`, `lead_id`,`deleted`) VALUES (
                     NULL, '" .$team. "', '" .$leadId. "', '0'
                    )";
                $statement = $db->prepare($sql);
                $statement->execute();
        }
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage()); 
    }
}

/**
 * Get users teams according to the user id 
 * 
 * @global DB Resource $db
 * @param integer $userId
 */
function getLeadsTeamNames($leadId) 
{
    global $db;
    try {
        $getTeams = "SELECT tl.id,tl.team_id,t.name AS teamName 
                     FROM team_leads AS tl
                     LEFT JOIN teams AS t ON tl.team_id = t.id
                     WHERE tl.lead_id = '" .$leadId."'  
                     AND tl.deleted = '0'";

        $statement = $db->prepare($getTeams);
        $statement->execute();      
        $usersTeams = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return (!empty($usersTeams))? $usersTeams : NULL;
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

/**
 * Updating leads team according to the team ids. First removing previous teams
 * and adding new teams again for lead id.
 * 
 * @param array $teamIds
 * @param integer $lead
 * @throws Exception
 */
function updateLeadsTeam($teamIds, $lead)
{
    global $db;
    try {
        $teams = "DELETE FROM team_leads 
                  WHERE lead_id = '" .$lead. "'";
        
        $statement = $db->prepare($teams);
        $statement->execute();      
        
        addLeadsTeams($teamIds,$lead);
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }    
}