<?php

namespace App\Controller;

use App\Entity\Log;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogController extends AbstractController
{
    #[Route('/log', name: 'app_log')]
    public function __invoke(Request $request, ManagerRegistry $doctrine)
    {
        return [ 'counter' => $doctrine
            ->getRepository(Log::class)
            ->getFilteredCount([
                'services' => $request->get('serviceNames'),
                'status'   => $request->get('statusCode'),
                'start'    => $request->get('startDate'),
                'end'      => $request->get('startDate'),
            ])
        ];
    }
}
