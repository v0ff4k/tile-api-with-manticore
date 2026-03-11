<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    #[Groups(['order:read'])]
    private ?string $hash = null;

    #[ORM\Column(nullable: true)]
    private ?int $userId = null;

    #[ORM\Column(length: 64)]
    private ?string $token = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['order:read'])]
    private ?string $number = null;

    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $status = 1;

    #[ORM\Column(length: 180, nullable: true)]
    #[Groups(['order:read'])]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $vatType = 0;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $vatNumber = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $taxNumber = null;

    #[ORM\Column(nullable: true)]
    private ?int $discount = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    #[Groups(['order:read'])]
    private ?float $delivery = null;

    #[ORM\Column(nullable: true)]
    private ?int $deliveryType = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['order:read'])]
    private ?\DateTimeInterface $deliveryTimeMin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['order:read'])]
    private ?\DateTimeInterface $deliveryTimeMax = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryTimeConfirmMin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryTimeConfirmMax = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryTimeFastPayMin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryTimeFastPayMax = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryOldTimeMin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryOldTimeMax = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $deliveryIndex = null;

    #[ORM\Column(nullable: true)]
    private ?int $deliveryCountry = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $deliveryRegion = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[Groups(['order:read'])]
    private ?string $deliveryCity = null;

    #[ORM\Column(length: 300, nullable: true)]
    #[Groups(['order:read'])]
    private ?string $deliveryAddress = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $deliveryBuilding = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $deliveryPhoneCode = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $deliveryPhone = null;

    #[ORM\Column(nullable: true)]
    private ?int $sex = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['order:read'])]
    private ?string $clientName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['order:read'])]
    private ?string $clientSurname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column]
    private ?int $payType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $payDateExecution = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $offsetDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $offsetReason = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $proposedDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $shipDate = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $trackingNumber = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $managerName = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $managerEmail = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $managerPhone = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $carrierName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carrierContactData = null;

    #[ORM\Column(length: 5)]
    private ?string $locale = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true, options: ['default' => 1])]
    private ?float $curRate = 1;

    #[ORM\Column(length: 3, options: ['default' => 'EUR'])]
    private ?string $currency = 'EUR';

    #[ORM\Column(length: 3, options: ['default' => 'm'])]
    private ?string $measure = 'm';

    #[ORM\Column(length: 200)]
    #[Groups(['order:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['order:read'])]
    private ?\DateTimeInterface $createDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateDate = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $warehouseData = null;

    #[ORM\Column(options: ['default' => 1])]
    private ?int $step = 1;

    #[ORM\Column(nullable: true, options: ['default' => 1])]
    private ?bool $addressEqual = true;

    #[ORM\Column(nullable: true)]
    private ?bool $bankTransferRequested = null;

    #[ORM\Column(nullable: true)]
    private ?bool $acceptPay = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cancelDate = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $weightGross = null;

    #[ORM\Column(nullable: true)]
    private ?bool $productReview = null;

    #[ORM\Column(nullable: true)]
    private ?int $mirror = null;

    #[ORM\Column(nullable: true)]
    private ?bool $process = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $factDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $entranceReview = null;

    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?bool $paymentEuro = false;

    #[ORM\Column(nullable: true)]
    private ?bool $specPrice = null;

    #[ORM\Column(nullable: true)]
    private ?bool $showMsg = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $deliveryPriceEuro = null;

    #[ORM\Column(nullable: true)]
    private ?int $addressPayer = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sendingDate = null;

    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?int $deliveryCalculateType = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fullPaymentDate = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $bankDetails = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $deliveryApartmentOffice = null;

    /**
     * @var Collection<int, OrderArticle>
     */
    #[ORM\OneToMany(targetEntity: OrderArticle::class, mappedBy: 'order', cascade: ['persist', 'remove'])]
    #[Groups(['order:read'])]
    private Collection $orderArticles;

    public function __construct()
    {
        $this->orderArticles = new ArrayCollection();
        $this->createDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): static
    {
        $this->hash = $hash;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getVatType(): ?int
    {
        return $this->vatType;
    }

    public function setVatType(int $vatType): static
    {
        $this->vatType = $vatType;

        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(?string $vatNumber): static
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(?string $taxNumber): static
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getDelivery(): ?float
    {
        return $this->delivery;
    }

    public function setDelivery(?float $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getDeliveryType(): ?int
    {
        return $this->deliveryType;
    }

    public function setDeliveryType(?int $deliveryType): static
    {
        $this->deliveryType = $deliveryType;

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

    public function getDeliveryTimeConfirmMin(): ?\DateTimeInterface
    {
        return $this->deliveryTimeConfirmMin;
    }

    public function setDeliveryTimeConfirmMin(?\DateTimeInterface $deliveryTimeConfirmMin): static
    {
        $this->deliveryTimeConfirmMin = $deliveryTimeConfirmMin;

        return $this;
    }

    public function getDeliveryTimeConfirmMax(): ?\DateTimeInterface
    {
        return $this->deliveryTimeConfirmMax;
    }

    public function setDeliveryTimeConfirmMax(?\DateTimeInterface $deliveryTimeConfirmMax): static
    {
        $this->deliveryTimeConfirmMax = $deliveryTimeConfirmMax;

        return $this;
    }

    public function getDeliveryTimeFastPayMin(): ?\DateTimeInterface
    {
        return $this->deliveryTimeFastPayMin;
    }

    public function setDeliveryTimeFastPayMin(?\DateTimeInterface $deliveryTimeFastPayMin): static
    {
        $this->deliveryTimeFastPayMin = $deliveryTimeFastPayMin;

        return $this;
    }

    public function getDeliveryTimeFastPayMax(): ?\DateTimeInterface
    {
        return $this->deliveryTimeFastPayMax;
    }

    public function setDeliveryTimeFastPayMax(?\DateTimeInterface $deliveryTimeFastPayMax): static
    {
        $this->deliveryTimeFastPayMax = $deliveryTimeFastPayMax;

        return $this;
    }

    public function getDeliveryOldTimeMin(): ?\DateTimeInterface
    {
        return $this->deliveryOldTimeMin;
    }

    public function setDeliveryOldTimeMin(?\DateTimeInterface $deliveryOldTimeMin): static
    {
        $this->deliveryOldTimeMin = $deliveryOldTimeMin;

        return $this;
    }

    public function getDeliveryOldTimeMax(): ?\DateTimeInterface
    {
        return $this->deliveryOldTimeMax;
    }

    public function setDeliveryOldTimeMax(?\DateTimeInterface $deliveryOldTimeMax): static
    {
        $this->deliveryOldTimeMax = $deliveryOldTimeMax;

        return $this;
    }

    public function getDeliveryIndex(): ?string
    {
        return $this->deliveryIndex;
    }

    public function setDeliveryIndex(?string $deliveryIndex): static
    {
        $this->deliveryIndex = $deliveryIndex;

        return $this;
    }

    public function getDeliveryCountry(): ?int
    {
        return $this->deliveryCountry;
    }

    public function setDeliveryCountry(?int $deliveryCountry): static
    {
        $this->deliveryCountry = $deliveryCountry;

        return $this;
    }

    public function getDeliveryRegion(): ?string
    {
        return $this->deliveryRegion;
    }

    public function setDeliveryRegion(?string $deliveryRegion): static
    {
        $this->deliveryRegion = $deliveryRegion;

        return $this;
    }

    public function getDeliveryCity(): ?string
    {
        return $this->deliveryCity;
    }

    public function setDeliveryCity(?string $deliveryCity): static
    {
        $this->deliveryCity = $deliveryCity;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?string $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getDeliveryBuilding(): ?string
    {
        return $this->deliveryBuilding;
    }

    public function setDeliveryBuilding(?string $deliveryBuilding): static
    {
        $this->deliveryBuilding = $deliveryBuilding;

        return $this;
    }

    public function getDeliveryPhoneCode(): ?string
    {
        return $this->deliveryPhoneCode;
    }

    public function setDeliveryPhoneCode(?string $deliveryPhoneCode): static
    {
        $this->deliveryPhoneCode = $deliveryPhoneCode;

        return $this;
    }

    public function getDeliveryPhone(): ?string
    {
        return $this->deliveryPhone;
    }

    public function setDeliveryPhone(?string $deliveryPhone): static
    {
        $this->deliveryPhone = $deliveryPhone;

        return $this;
    }

    public function getSex(): ?int
    {
        return $this->sex;
    }

    public function setSex(?int $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(?string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getClientSurname(): ?string
    {
        return $this->clientSurname;
    }

    public function setClientSurname(?string $clientSurname): static
    {
        $this->clientSurname = $clientSurname;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getPayType(): ?int
    {
        return $this->payType;
    }

    public function setPayType(int $payType): static
    {
        $this->payType = $payType;

        return $this;
    }

    public function getPayDateExecution(): ?\DateTimeInterface
    {
        return $this->payDateExecution;
    }

    public function setPayDateExecution(?\DateTimeInterface $payDateExecution): static
    {
        $this->payDateExecution = $payDateExecution;

        return $this;
    }

    public function getOffsetDate(): ?\DateTimeInterface
    {
        return $this->offsetDate;
    }

    public function setOffsetDate(?\DateTimeInterface $offsetDate): static
    {
        $this->offsetDate = $offsetDate;

        return $this;
    }

    public function getOffsetReason(): ?int
    {
        return $this->offsetReason;
    }

    public function setOffsetReason(?int $offsetReason): static
    {
        $this->offsetReason = $offsetReason;

        return $this;
    }

    public function getProposedDate(): ?\DateTimeInterface
    {
        return $this->proposedDate;
    }

    public function setProposedDate(?\DateTimeInterface $proposedDate): static
    {
        $this->proposedDate = $proposedDate;

        return $this;
    }

    public function getShipDate(): ?\DateTimeInterface
    {
        return $this->shipDate;
    }

    public function setShipDate(?\DateTimeInterface $shipDate): static
    {
        $this->shipDate = $shipDate;

        return $this;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(?string $trackingNumber): static
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    public function getManagerName(): ?string
    {
        return $this->managerName;
    }

    public function setManagerName(?string $managerName): static
    {
        $this->managerName = $managerName;

        return $this;
    }

    public function getManagerEmail(): ?string
    {
        return $this->managerEmail;
    }

    public function setManagerEmail(?string $managerEmail): static
    {
        $this->managerEmail = $managerEmail;

        return $this;
    }

    public function getManagerPhone(): ?string
    {
        return $this->managerPhone;
    }

    public function setManagerPhone(?string $managerPhone): static
    {
        $this->managerPhone = $managerPhone;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(?string $carrierName): static
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierContactData(): ?string
    {
        return $this->carrierContactData;
    }

    public function setCarrierContactData(?string $carrierContactData): static
    {
        $this->carrierContactData = $carrierContactData;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getCurRate(): ?float
    {
        return $this->curRate;
    }

    public function setCurRate(?float $curRate): static
    {
        $this->curRate = $curRate;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMeasure(): ?string
    {
        return $this->measure;
    }

    public function setMeasure(string $measure): static
    {
        $this->measure = $measure;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): static
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): static
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getWarehouseData(): ?array
    {
        return $this->warehouseData;
    }

    public function setWarehouseData(?array $warehouseData): static
    {
        $this->warehouseData = $warehouseData;

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(int $step): static
    {
        $this->step = $step;

        return $this;
    }

    public function isAddressEqual(): ?bool
    {
        return $this->addressEqual;
    }

    public function setAddressEqual(?bool $addressEqual): static
    {
        $this->addressEqual = $addressEqual;

        return $this;
    }

    public function isBankTransferRequested(): ?bool
    {
        return $this->bankTransferRequested;
    }

    public function setBankTransferRequested(?bool $bankTransferRequested): static
    {
        $this->bankTransferRequested = $bankTransferRequested;

        return $this;
    }

    public function isAcceptPay(): ?bool
    {
        return $this->acceptPay;
    }

    public function setAcceptPay(?bool $acceptPay): static
    {
        $this->acceptPay = $acceptPay;

        return $this;
    }

    public function getCancelDate(): ?\DateTimeInterface
    {
        return $this->cancelDate;
    }

    public function setCancelDate(?\DateTimeInterface $cancelDate): static
    {
        $this->cancelDate = $cancelDate;

        return $this;
    }

    public function getWeightGross(): ?float
    {
        return $this->weightGross;
    }

    public function setWeightGross(?float $weightGross): static
    {
        $this->weightGross = $weightGross;

        return $this;
    }

    public function isProductReview(): ?bool
    {
        return $this->productReview;
    }

    public function setProductReview(?bool $productReview): static
    {
        $this->productReview = $productReview;

        return $this;
    }

    public function getMirror(): ?int
    {
        return $this->mirror;
    }

    public function setMirror(?int $mirror): static
    {
        $this->mirror = $mirror;

        return $this;
    }

    public function isProcess(): ?bool
    {
        return $this->process;
    }

    public function setProcess(?bool $process): static
    {
        $this->process = $process;

        return $this;
    }

    public function getFactDate(): ?\DateTimeInterface
    {
        return $this->factDate;
    }

    public function setFactDate(?\DateTimeInterface $factDate): static
    {
        $this->factDate = $factDate;

        return $this;
    }

    public function getEntranceReview(): ?int
    {
        return $this->entranceReview;
    }

    public function setEntranceReview(?int $entranceReview): static
    {
        $this->entranceReview = $entranceReview;

        return $this;
    }

    public function isPaymentEuro(): ?bool
    {
        return $this->paymentEuro;
    }

    public function setPaymentEuro(?bool $paymentEuro): static
    {
        $this->paymentEuro = $paymentEuro;

        return $this;
    }

    public function isSpecPrice(): ?bool
    {
        return $this->specPrice;
    }

    public function setSpecPrice(?bool $specPrice): static
    {
        $this->specPrice = $specPrice;

        return $this;
    }

    public function isShowMsg(): ?bool
    {
        return $this->showMsg;
    }

    public function setShowMsg(?bool $showMsg): static
    {
        $this->showMsg = $showMsg;

        return $this;
    }

    public function getDeliveryPriceEuro(): ?float
    {
        return $this->deliveryPriceEuro;
    }

    public function setDeliveryPriceEuro(?float $deliveryPriceEuro): static
    {
        $this->deliveryPriceEuro = $deliveryPriceEuro;

        return $this;
    }

    public function getAddressPayer(): ?int
    {
        return $this->addressPayer;
    }

    public function setAddressPayer(?int $addressPayer): static
    {
        $this->addressPayer = $addressPayer;

        return $this;
    }

    public function getSendingDate(): ?\DateTimeInterface
    {
        return $this->sendingDate;
    }

    public function setSendingDate(?\DateTimeInterface $sendingDate): static
    {
        $this->sendingDate = $sendingDate;

        return $this;
    }

    public function getDeliveryCalculateType(): ?int
    {
        return $this->deliveryCalculateType;
    }

    public function setDeliveryCalculateType(?int $deliveryCalculateType): static
    {
        $this->deliveryCalculateType = $deliveryCalculateType;

        return $this;
    }

    public function getFullPaymentDate(): ?\DateTimeInterface
    {
        return $this->fullPaymentDate;
    }

    public function setFullPaymentDate(?\DateTimeInterface $fullPaymentDate): static
    {
        $this->fullPaymentDate = $fullPaymentDate;

        return $this;
    }

    public function getBankDetails(): ?array
    {
        return $this->bankDetails;
    }

    public function setBankDetails(?array $bankDetails): static
    {
        $this->bankDetails = $bankDetails;

        return $this;
    }

    public function getDeliveryApartmentOffice(): ?string
    {
        return $this->deliveryApartmentOffice;
    }

    public function setDeliveryApartmentOffice(?string $deliveryApartmentOffice): static
    {
        $this->deliveryApartmentOffice = $deliveryApartmentOffice;

        return $this;
    }

    /**
     * @return Collection<int, OrderArticle>
     */
    public function getOrderArticles(): Collection
    {
        return $this->orderArticles;
    }

    public function addOrderArticle(OrderArticle $orderArticle): static
    {
        if (!$this->orderArticles->contains($orderArticle)) {
            $this->orderArticles->add($orderArticle);
            $orderArticle->setOrder($this);
        }

        return $this;
    }

    public function removeOrderArticle(OrderArticle $orderArticle): static
    {
        if ($this->orderArticles->removeElement($orderArticle)) {
            if ($orderArticle->getOrder() === $this) {
                $orderArticle->setOrder(null);
            }
        }

        return $this;
    }
}