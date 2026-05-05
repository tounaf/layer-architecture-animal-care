<?php

namespace UI\Http\Rest\Admin\Controller;

use Application\Shared\Dashboard\DashboardStatsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/dashboard', name: 'api_admin_dashboard_')]
class DashboardStatsController extends AbstractController
{
    public function __construct(
        private DashboardStatsProvider $statsProvider
    ) {
    }

    #[Route('/kpis', name: 'kpis', methods: ['GET'])]
    public function getKpis(): JsonResponse
    {
        return new JsonResponse($this->statsProvider->getKpis());
    }

    #[Route('/upcoming-appointments', name: 'upcoming_appointments', methods: ['GET'])]
    public function getUpcomingAppointments(): JsonResponse
    {
        return new JsonResponse($this->statsProvider->getUpcomingAppointments());
    }

    #[Route('/species-repartition', name: 'species_repartition', methods: ['GET'])]
    public function getSpeciesRepartition(): JsonResponse
    {
        return new JsonResponse($this->statsProvider->getSpeciesRepartition());
    }
}
