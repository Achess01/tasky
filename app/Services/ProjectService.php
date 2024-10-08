<?php

namespace Tasky\Services;

use Tasky\Models\Project;

class ProjectService
{
    public Project $projectModel;

    public function __construct(Project $projectModel)
    {
        $this->projectModel = $projectModel;
    }

    public function getProjects(int $user_id): array
    {
        return $this->projectModel->findUserProjects($user_id) ?? [];
    }

    public function getProjectById(int $project_id, int $user_id): mixed
    {
        return $this->projectModel->findProjectById($project_id, $user_id) ?? null;
    }

    public function getTasksByProject(int $project_id, int $user_id): array
    {
        return $this->projectModel->findTasksByProject($project_id, $user_id) ?? [];
    }

    public function getTasksById(int $task_id): mixed
    {
        return $this->projectModel->findTaskById($task_id) ?? null;
    }

    public function getStatus(): array
    {
        return $this->projectModel->findStatus() ?? [];
    }

    public function updateTaskStatus(int $task_id, int $new_status)
    {
        return $this->projectModel->updateTaskStatus($task_id, $new_status) ?? null;
    }

    public function hasPermissionsByProject(int $project_id, int $user_id, string $action, string $entity): bool
    {
        return boolval($this->projectModel->findPermissionsByProject($project_id, $user_id, $action, $entity));
    }

    public function createProject(array $data, int $user_id): mixed
    {
        return $this->projectModel->createProject($data, $user_id) ?? null;
    }

    public function createTask(array $data): mixed
    {
        return $this->projectModel->createTask($data) ?? null;
    }

    public function updateTask(array $data): int
    {
        return $this->projectModel->updateTask($data);
    }

    public function getUsersByProject(int $project_id): array
    {
        return $this->projectModel->findUsersByProjectId($project_id);
    }

    public function usersToAdd(int $project_id): array
    {
        return $this->projectModel->notInProjectUsers($project_id);
    }
}