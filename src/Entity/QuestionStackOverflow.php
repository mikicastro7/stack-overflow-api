<?php

namespace App\Entity;

use App\Repository\QuestionStackOverflowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DatesTrait;

#[ORM\Entity(repositoryClass: QuestionStackOverflowRepository::class)]
#[ORM\UniqueConstraint(fields: ['stackOverflowId'], name: 'uniq_stack_overflow_id')]

class QuestionStackOverflow
{
    use DatesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $stackOverflowId = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\ManyToMany(targetEntity: QuestionsStackOverflowRequest::class, inversedBy: 'questionsStackOverflow')]
    private Collection $QuestionStackOverflowRequestId;

    public function __construct()
    {
        $this->QuestionStackOverflowRequestId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStackOverflowId(): ?int
    {
        return $this->stackOverflowId;
    }

    public function setStackOverflowId(int $stackOverflowId): static
    {
        $this->stackOverflowId = $stackOverflowId;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return Collection<int, QuestionsStackOverflowRequest>
     */
    public function getQuestionStackOverflowRequestId(): Collection
    {
        return $this->QuestionStackOverflowRequestId;
    }

    public function addQuestionStackOverflowRequestId(QuestionsStackOverflowRequest $questionStackOverflowRequestId): static
    {
        if (!$this->QuestionStackOverflowRequestId->contains($questionStackOverflowRequestId)) {
            $this->QuestionStackOverflowRequestId->add($questionStackOverflowRequestId);
        }

        return $this;
    }

    public function removeQuestionStackOverflowRequestId(QuestionsStackOverflowRequest $questionStackOverflowRequestId): static
    {
        $this->QuestionStackOverflowRequestId->removeElement($questionStackOverflowRequestId);

        return $this;
    }
}
