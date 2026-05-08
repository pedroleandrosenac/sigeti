<?php

namespace App\Controllers\Technician;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;
use App\Models\Ticket\Ticket;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_TECHNICIAN_DASHBOARD);
    }

    public function index(): void
    {
        Auth::requirePermission(Permission::VIEW_TECHNICIAN_DASHBOARD);

        $ticketModel = new Ticket();
        $tickets = (new Ticket())->ticketsOrderedByStatusPriorityAndOpeningDate();

        $quantityTicketsByMonth = $ticketModel->countTicketsByMonth(2024);
        $quantityTicketsByCategory = $ticketModel->countTicketsByCategory(2024);
        $quantityTicketsByStatus = $ticketModel->countTicketsByStatus(2024);

        $avgResolutionDays = $ticketModel->avgResolutionDaysByMonthCurrentYear(2024);
        $ticketsByPriorityAndStatus = $ticketModel->countByPriorityAndStatusCurrentYear(2024);

        echo $this->view->render("technician/dashboard", [
            "tickets" => $tickets,
            "quantityTicketsByMonth" => $quantityTicketsByMonth,
            "quantityTicketsByCategory" => $quantityTicketsByCategory,
            "quantityTicketsByStatus" => $quantityTicketsByStatus,

            "avgResolutionDays" => $avgResolutionDays,
            "ticketsByPriorityAndStatus" => $ticketsByPriorityAndStatus,
        ]);
    }
}