<?php

namespace Tasky\Models;
use PDO;
use Tasky\Services\Database;

class ReportModel
{
    private PDO $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function getTasksByUserAndProject(): ?array
    {
        $stmt = $this->db->query("
            SELECT u.email, p.name AS project_name, COUNT(t.task_id) AS task_count
            FROM adm_task t
            INNER JOIN adm_user u ON t.assigned_user_id = u.user_id
            INNER JOIN adm_project p ON t.project_id = p.project_id
            GROUP BY u.email, p.name
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTaskCountByStatus(): ?array
    {
        $stmt = $this->db->query("
            SELECT pts.name AS status_name, COUNT(t.task_id) AS task_count
            FROM adm_task t
            INNER JOIN project_task_status pts ON t.project_task_status = pts.project_task_status
            GROUP BY pts.name
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalTimeByProject(): ?array
    {
        $stmt = $this->db->query("
            SELECT p.name AS project_name, SUM(tt.time_tracked) AS total_time
            FROM time_tracking tt
            INNER JOIN adm_task t ON tt.task_id = t.task_id
            INNER JOIN adm_project p ON t.project_id = p.project_id
            GROUP BY p.name
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTaskStatusHistory(): ?array
    {
        $stmt = $this->db->query("
            SELECT t.name AS task_name, tsl.changed_on, ps.name AS previous_status, ns.name AS new_status
            FROM task_status_log tsl
            INNER JOIN adm_task t ON tsl.task_id = t.task_id
            INNER JOIN project_task_status ps ON tsl.previous_status_id = ps.project_task_status
            INNER JOIN project_task_status ns ON tsl.new_status_id = ns.project_task_status
            ORDER BY t.name, tsl.changed_on
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

