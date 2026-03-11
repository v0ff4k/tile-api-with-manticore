<?php

namespace App\Entity;

use App\Repository\OrderArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderArticleRepository::class)]
#[ORM\Table(name: 'orders_article')]
class OrderArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderArticles')]
    #[ORM\JoinColumn(name: 'orders_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Order $order = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['order:read'])]
    private ?int $articleId = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['order:read'])]
    private ?float $amount = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['order:read'])]
    private ?float $price = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $priceEur = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $currency = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $measure = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryTimeMin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryTimeMax = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $weight = null;

    #[ORM\Column(nullable: true)]
    private ?int $multiplePallet = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $packagingCount = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $pallet = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $packaging = null;

    #[ORM\Column(options: ['default' => 0])]
    private ?bool $swimmingPool = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    public function setArticleId(?int $articleId): static
    {
        $this->articleId = $articleId;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceEur(): ?float
    {
        return $this->priceEur;
    }

    public function setPriceEur(?float $priceEur): static
    {
        $this->priceEur = $priceEur;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMeasure(): ?string
    {
        return $this->measure;
    }

    public function setMeasure(?string $measure): static
    {
        $this->measure = $measure;

        return $this;
    }

    public function getDeliveryTimeMin(): ?\DateTimeInterface
    {
        return $this->deliveryTimeMin;
    }

    public function setDeliveryTimeMin(?\DateTimeInterface $deliveryTimeMin): static
    {
        $this->deliveryTimeMin = $deliveryTimeMin;

        return $this;
    }

    public function getDeliveryTimeMax(): ?\DateTimeInterface
    {
        return $this->deliveryTimeMax;
    }

    public function setDeliveryTimeMax(?\DateTimeInterface $deliveryTimeMax): static
    {
        $this->deliveryTimeMax = $deliveryTimeMax;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getMultiplePallet(): ?int
    {
        return $this->multiplePallet;
    }

    public function setMultiplePallet(?int $multiplePallet): static
    {
        $this->multiplePallet = $multiplePallet;

        return $this;
    }

    public function getPackagingCount(): ?float
    {
        return $this->packagingCount;
    }

    public function setPackagingCount(float $packagingCount): static
    {
        $this->packagingCount = $packagingCount;

        return $this;
    }

    public function getPallet(): ?float
    {
        return $this->pallet;
    }

    public function setPallet(float $pallet): static
    {
        $this->pallet = $pallet;

        return $this;
    }

    public function getPackaging(): ?float
    {
        return $this->packaging;
    }

    public function setPackaging(float $packaging): static
    {
        $this->packaging = $packaging;

        return $this;
    }

    public function isSwimmingPool(): ?bool
    {
        return $this->swimmingPool;
    }

    public function setSwimmingPool(bool $swimmingPool): static
    {
        $this->swimmingPool = $swimmingPool;

        return $this;
    }
}
