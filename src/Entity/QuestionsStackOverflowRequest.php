<?php

namespace App\Entity;

use App\Repository\QuestionsStackOverflowRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DatesTrait;

#[ORM\Entity(repositoryClass: QuestionsStackOverflowRequestRepository::class)]
class QuestionsStackOverflowRequest
{
    use DatesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tagged;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $fromdate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $todate = null;

    #[ORM\ManyToMany(targetEntity: QuestionStackOverflow::class, mappedBy: 'QuestionStackOverflowRequestId')]
    private Collection $questionsStackOverflow;

    public function __construct()
    {
        $this->questionsStackOverflow = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagged(): ?string
    {
        return $this->tagged;
    }

    public function setTagged(string $tagged): static
    {
        $this->tagged = $tagged;

        return $this;
    }

    public function getFromdate(): ?\DateTimeInterface
    {
        return $this->fromdate;
    }

    public function setFromdate(?\DateTimeInterface $fromdate): self
    {
        $this->fromdate = $fromdate;
        return $this;
    }

    public function getTodate(): ?\DateTimeInterface
    {
        return $this->todate;
    }

    public function setTodate(?\DateTimeInterface $todate): self
    {
        $this->todate = $todate;
        return $this;
    }

    /**
     * @return Collection<int, QuestionStackOverflow>
     */
    public function getQuestionsStackOverflow(): Collection
    {
        return $this->questionsStackOverflow;
    }

    public function addQuestionsStackOverflow(QuestionStackOverflow $questionsStackOverflow): static
    {
        if (!$this->questionsStackOverflow->contains($questionsStackOverflow)) {
            $this->questionsStackOverflow->add($questionsStackOverflow);
            $questionsStackOverflow->addQuestionStackOverflowRequestId($this);
        }

        return $this;
    }

    public function removeQuestionsStackOverflow(QuestionStackOverflow $questionsStackOverflow): static
    {
        if ($this->questionsStackOverflow->removeElement($questionsStackOverflow)) {
            $questionsStackOverflow->removeQuestionStackOverflowRequestId($this);
        }

        return $this;
    }
}
