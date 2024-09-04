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
            INNER JOIN adm_user au on apur.user_id = au.user_id 
            INNER JOIN adm_role ar on apur.role_id = ar.role_id 
            INNER JOIN adm_role_permission arp on arp.role_id = ar.role_id 
            INNER JOIN adm_permission aper on aper.permission_id = arp.permission_id 
            WHERE au.user_id = :user_id AND aper.action = :action AND aper.entity = :entity AND ap.project_id = apur.project_id 
            AND ar.active = true AND aper.active = true 
            ORDER BY ap.estimate_end_date ASC
            "
        );
        $stmt->execute(['user_id' => $user_id, 'action' => 'read', 'entity' => 'project']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }
}

