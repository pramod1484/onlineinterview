<?php

/**
 * This file will contains the function related to the leads team.
 * 
 */

require_once 'database.php';

/**
 * Adding entity to different teams. 
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return void
 */
function addTeams(Array $teamIds, $leadId,  $entityType)
{
    global  $db;
     try {
        foreach ($teamIds as $team) {
            $sql = "INSERT INTO `entity_team`(
                    `id`, `entity_id`, `team_id`,`entity_type`,`deleted`) VALUES (
                     NULL,  '" .$leadId. "','" .$team. "','".$entityType."','0'
                    )";
            //echo $sql; exit;
                $statement = $db->prepare($sql);
                $statement->execute();
        }
    } catch (Exception $exception) {
        echo $sql; exit;
        throw new Exception($exception->getMessage()); 
    }
}

/**
 * Get entity teams according to the user id 
 * 
 * @global DB Resource $db
 * @param integer $userId
 */
function getTeamNames($entityId, $entityType) {
    global $db;
    $getTeams = "SELECT et.id,et.team_id,t.name AS teamName 
                         FROM entity_team AS et
                         LEFT JOIN teams AS t ON et.team_id = t.id
                         WHERE et.entity_id = '" . $entityId . "' 
                         AND et.entity_type = '$entityType'
                         AND et.deleted = '0' ORDER BY teamName ASC";

    try {
        $statement = $db->prepare($getTeams);
        $statement->execute();
        $usersTeams = $statement->fetchAll(PDO::FETCH_ASSOC);

        return (!empty($usersTeams)) ? $usersTeams : NULL;
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

/**
 * Updating entity team according to the team ids. First removing previous teams
 * and adding new teams again for lead id.
 * 
 * @param array $teamIds
 * @param integer $lead
 * @throws Exception
 */
function updateTeam($teamIds,$entityId,$entityType)
{
    global $db;
    try {
        $teams = "DELETE FROM entity_team 
                  WHERE entity_id = '" .$entityId. "' and entity_type = '$entityType'";
        
        $statement = $db->prepare($teams);
        $statement->execute();      
        
        addTeams($teamIds, $entityId, $entityType);
    } catch (Exception $exception) {
        echo $exception; //throw new Exception($exception->getMessage());
    }    
}