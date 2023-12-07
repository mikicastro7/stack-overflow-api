<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StackOverflowService;

class StackOverflowController extends AbstractController
{
    private $stackOverflowService;

    public function __construct(StackOverflowService $stackOverflowService)
    {
        $this->stackOverflowService = $stackOverflowService;
    }

    #[Route('/stackoverflow-questions', name: 'stackoverflow_questions', methods: ['GET'])]
    public function getStackOverflowQuestions(Request $request): JsonResponse
    {
        $tagged = $request->query->get('tagged');
        $toDate = $request->query->get('todate');
        $fromDate = $request->query->get('fromdate');

        if (!$tagged) {
            return $this->json(['error' => 'The tagged parameter is required.'], 400);
        }

        try {
            $items = $this->stackOverflowService->handleQuestionsRequest($tagged, $toDate, $fromDate);

            return $this->json([
                'success' => true,
                'items' => $items,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}