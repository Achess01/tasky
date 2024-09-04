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
            "SELECT ap.* FROM adm_project ap INNER JOIN adm_project_user_role apur on ap.project_id = apur.project_id INNER JOIN adm_user au on apur.user_id = au.user_id WHERE au.user_id = :user_id"
        );
        $stmt->execute(['user_id' => $user_id,]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }
}

