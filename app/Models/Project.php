<?php

namespace Tasky\Models;

use Tasky\Services\Database;
use PDO;

class Project
{
    private PDO $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function findUserProjects(int $user_id): ?array
    {
        $stmt = $this->db->prepare(
            "
            SELECT ap.* 
            FROM adm_project ap 
            INNER JOIN adm_project_user_role apur on ap.project_id = apur.project_id 
            INNER JOIN adm_role ar on apur.role_id = ar.role_id 
            INNER JOIN adm_role_permission arp on arp.role_id = ar.role_id 
            INNER JOIN adm_permission aper on aper.permission_id = arp.permission_id 
            WHERE apur.user_id = :user_id AND aper.action = :action AND aper.entity = :entity AND ap.project_id = apur.project_id 
            AND ar.active = true AND aper.active = true 
            ORDER BY ap.estimate_end_date
            "
        );
        $stmt->execute(['user_id' => $user_id, 'action' => 'read', 'entity' => 'project']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }

    public function findProjectById(int $project_id, int $user_id): mixed
    {
        $stmt = $this->db->prepare(
            "
            SELECT ap.* 
            FROM adm_project ap 
            INNER JOIN adm_project_user_role apur on ap.project_id = apur.project_id 
            INNER JOIN adm_role ar on apur.role_id = ar.role_id 
            INNER JOIN adm_role_permission arp on arp.role_id = ar.role_id 
            INNER JOIN adm_permission aper on aper.permission_id = arp.permission_id 
            WHERE apur.user_id = :user_id AND aper.action = :action AND aper.entity = :entity AND ap.project_id = :project_id 
            AND ar.active = true AND aper.active = true 
            ORDER BY ap.estimate_end_date
            "
        );
        $stmt->execute(['user_id' => $user_id, 'action' => 'read', 'entity' => 'project', 'project_id' => $project_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findTasksByProject(int $project_id, int $user_id): ?array
    {
        $stmt = $this->db->prepare(
            "
            SELECT t.* 
            FROM adm_task t  
            INNER JOIN adm_project ap on ap.project_id = t.project_id
            INNER JOIN adm_project_user_role apur on ap.project_id = apur.project_id 
            INNER JOIN adm_role ar on apur.role_id = ar.role_id 
            INNER JOIN adm_role_permission arp on arp.role_id = ar.role_id 
            INNER JOIN adm_permission aper on aper.permission_id = arp.permission_id 
            WHERE apur.user_id = :user_id 
              AND aper.action = :action 
              AND aper.entity = :entity 
              AND ap.project_id = :project_id 
              AND ar.active = true 
              AND aper.active = true
            "
        );
        $stmt->execute(['user_id' => $user_id, 'action' => 'read', 'entity' => 'task', 'project_id' => $project_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }

    public function findStatus(): ?array
    {
        $stmt = $this->db->prepare(
            "
            SELECT * 
            FROM project_task_status t
            ORDER BY status_order;
            "
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateTaskStatus(int $task_id, int $new_task_status): mixed
    {
        $task = $this->findTask($task_id);
        if ($task !== null) {
            $stmt = $this->db->prepare("
                INSERT INTO task_status_log (changed_on, task_id,previous_status_id, new_status_id) 
                VALUES (NOW(), :task_id, :prev, :new_status_id)
            ");
            $stmt->execute(['prev' => $task['project_task_status'], 'new_status_id' => $new_task_status, 'task_id' => $task_id]);
        }

        $stmt = $this->db->prepare('UPDATE adm_task SET project_task_status = :project_task_status WHERE task_id = :task_id');
        $stmt->execute(['project_task_status' => $new_task_status, 'task_id' => $task_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    public function findTask(int $task_id): mixed
    {
        $stmt = $this->db->prepare(
            "
            SELECT * 
            FROM adm_task t
            WHERE t.task_id = :task_id;
            "
        );
        $stmt->execute(['task_id' => $task_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findPermissionsByProject(int $project_id, int $user_id, string $action, string $entity): ?array
    {
        $stmt = $this->db->prepare(
            "
            SELECT aper.* 
            FROM adm_permission aper
            INNER JOIN adm_role_permission arp on arp.permission_id = aper.permission_id
            INNER JOIN adm_role ar on arp.role_id = ar.role_id  
            INNER JOIN adm_project_user_role apur on ar.role_id = apur.role_id 
            INNER JOIN adm_user au on apur.user_id = au.user_id
            WHERE apur.user_id = :user_id 
              AND apur.project_id = :project_id
              AND aper.action = :action
              AND aper.entity = :entity
              AND ar.active = true 
              AND aper.active = true
            "
        );
        $stmt->execute(['user_id' => $user_id, 'project_id' => $project_id, 'action' => $action, 'entity' => $entity]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function createProject(array $data, int $user_id)
    {
        $stmt = $this->db->prepare("
                INSERT INTO adm_project (name, description, start_date, estimate_end_date) 
                VALUES (:name, :description, :start_date, :estimate_end_date)
            ");
        $stmt->execute($data);

        $last_id = $this->db->lastInsertId('adm_project');
        $stmt2 = $this->db->prepare("
                INSERT INTO adm_project_user_role (user_id, project_id, role_id) 
                VALUES (:user_id, :project_id, :role_id)
            ");
        $stmt2->execute(['user_id' => $user_id, 'project_id' => $last_id, 'role_id' => 1]);


        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

