<?php

namespace Tasky\Controllers;

use Tasky\models\ReportModel;

class ReportController
{
    private ReportModel $reportModel;

    public function __construct($reportModel)
    {
        $this->reportModel = $reportModel;
    }

    public function reportTasksByUserAndProject(): void
    {
        $data = $this->reportModel->getTasksByUserAndProject();
        require './app/Views/ReportTasksByUserAndProjectView.php';
    }

    public function reportTaskCountByStatus(): void
    {
        $data = $this->reportModel->getTaskCountByStatus();
        require './app/Views/ReportTaskCountByStatusView.php';
    }

    public function reportTotalTimeByProject(): void
    {
        $data = $this->reportModel->getTotalTimeByProject();
        require './app/Views/ReportTotalTimeByProjectView.php';
    }

    public function reportTaskStatusHistory(): void
    {
        $data = $this->reportModel->getTaskStatusHistory();
        require './app/Views/ReportTaskStatusHistoryView.php';
    }
}

