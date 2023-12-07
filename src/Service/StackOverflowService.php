<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\QuestionsStackOverflowRequestRepository;
use App\Repository\QuestionStackOverflowRepository;
use App\Entity\QuestionsStackOverflowRequest;
use App\Entity\QuestionStackOverflow;
use DateTime;

class StackOverflowService
{
    private HttpClientInterface $client;
    private EntityManagerInterface $entityManager;
    private QuestionsStackOverflowRequestRepository $questionsRequestRepository;
    private QuestionStackOverflowRepository $questionRepository;

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $entityManager,
        QuestionsStackOverflowRequestRepository $questionsRequestRepository,
        QuestionStackOverflowRepository $questionRepository
    )
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->questionsRequestRepository = $questionsRequestRepository;
        $this->questionRepository = $questionRepository;
    }

    public function handleQuestionsRequest(string $tagged, ?int $toDate = null, ?int $fromDate = null): array
    {
        $existingQuestionsRequest = $this->questionsRequestRepository->findOneBy([
            'tagged' => $tagged,
            'fromdate' => $fromDate ? new DateTime('@' . $fromDate) : new DateTime(),
            'todate' => $toDate ? new DateTime('@' . $toDate) : null,
        ]);

        if (!$existingQuestionsRequest) {
            $questionsRequest = $this->saveQuestionsRequest($tagged, $toDate, $fromDate);

            $questionsResponse = $this->getQuestions($tagged, $toDate, $fromDate);
            if (empty($questionsResponse['items'])) {
                if (!empty($questionsResponse['error_message'])) {
                    throw new \Exception($questionsResponse['error_message']);
                }
                return [];
            }
            $questions = $questionsResponse['items'];
            if (!empty($questions)) {
                [$notExistingQuestions, $existingQuestions] = $this->filterExistingAndNonExistingQuestions($questions);
                foreach ($notExistingQuestions as $question) {
                    $questionStackOverflow = new QuestionStackOverflow();
                    $questionStackOverflow->setStackOverflowId($question['question_id']);
                    $questionStackOverflow->setData($question);
                    $questionStackOverflow->setCreatedAt(new DateTime());
                    $questionStackOverflow->setUpdatedAt(new DateTime());

                    $this->entityManager->persist($questionStackOverflow);
                    $questionsRequest->addQuestionsStackOverflow($questionStackOverflow);
                }
                foreach ($existingQuestions as $question) {
                    $questionsRequest->addQuestionsStackOverflow($question);
                }
                $this->entityManager->flush();
            }
            return $questions;
        } else {
            $existongQuestions = array_map(function($question) {
                return $question->getData();
            }, $existingQuestionsRequest->getQuestionsStackOverflow()->toArray());
            return $existongQuestions;
        }
    }

    private function filterExistingAndNonExistingQuestions(array $questions): array
    {
        $existingQuestions = $this->questionRepository->findQuestionsByStackOverflowIds(array_column($questions, 'question_id'));

        $existingQuestionsIds = array_map(function($question) {
            return $question->getStackOverflowId();
        }, $existingQuestions);

        $notExistingQuestions = array_filter($questions, function ($question) use ($existingQuestionsIds) {
            return !in_array($question['question_id'], $existingQuestionsIds);
        });

        return [$notExistingQuestions, $existingQuestions];
    }

    private function getQuestions(string $tagged, ?int $toDate = null, ?int $fromDate = null): array
    {
        $apiUrl = 'https://api.stackexchange.com/2.3/questions?order=desc&sort=activity&site=stackoverflow' . '&tagged=' . urlencode($tagged);

        if (!empty($fromDate)) {
            $apiUrl .= '&fromDate=' . urlencode($fromDate);
        }

        if (!empty($toDate)) {
            $apiUrl .= '&todate=' . urlencode($toDate);
        }

        $response = $this->client->request('GET', $apiUrl);
        $data = $response->toArray();

        return $data;
    }

    private function saveQuestionsRequest(string $tagged, ?int $toDate = null, ?int $fromDate = null): QuestionsStackOverflowRequest
    {
        $questionsStackOverflowRequest = new QuestionsStackOverflowRequest();
        $questionsStackOverflowRequest->setTagged($tagged);
        $questionsStackOverflowRequest->setFromdate($fromDate ? new DateTime('@' . $fromDate) : new DateTime());
        $questionsStackOverflowRequest->setTodate($toDate ? new DateTime('@' . $toDate) : null);
        $questionsStackOverflowRequest->setCreatedAt(new DateTime());
        $questionsStackOverflowRequest->setUpdatedAt(new DateTime());

        $this->entityManager->persist($questionsStackOverflowRequest);
        $this->entityManager->flush();

        return $questionsStackOverflowRequest;
    }

}
?>