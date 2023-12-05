<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StackOverflowController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
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

        $apiUrl = 'https://api.stackexchange.com/2.3/questions?order=desc&sort=activity&site=stackoverflow';

        if (!empty($fromDate)) {
            $apiUrl .= '&fromDate=' . urlencode($fromDate);
        }

        if (!empty($toDate)) {
            $apiUrl .= '&todate=' . urlencode($toDate);
        }

        try {
            $response = $this->client->request('GET', $apiUrl);
            $data = $response->toArray();

            $items = $data['items'] ?? [];

            return $this->json([
                'success' => true,
                'items' => $items,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Error communicating with Stack Exchange API',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}