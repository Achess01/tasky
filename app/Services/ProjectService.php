<?php

namespace Tasky\Services;

use Tasky\Models\Project;

class ProjectService
{
    private Project $projectModel;

    public function __construct(Project $projectModel)
    {
        $this->projectModel = $projectModel;
    }

    public function getProjects(int $user_id): array {
        return $this->projectModel->findUserProjects($user_id);
    }
}