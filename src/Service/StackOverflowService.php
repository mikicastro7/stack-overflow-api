<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class StackOverflowService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getQuestions(string $tagged, ?string $toDate = null, ?string $fromDate = null): array
    {
        $apiUrl = 'https://api.stackexchange.com/2.3/questions?order=desc&sort=activity&site=stackoverflow';

        if (!empty($fromDate)) {
            $apiUrl .= '&fromDate=' . urlencode($fromDate);
        }

        if (!empty($toDate)) {
            $apiUrl .= '&todate=' . urlencode($toDate);
        }

        $response = $this->client->request('GET', $apiUrl);
        $data = $response->toArray();

        return $data['items'] ?? [];
    }
}
?>