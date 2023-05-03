<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class Objects
{
    /**
     * @var string
     *
     * @Groups("mapping")
     */
    private string $type;

    /**
     * @var string//Category
     *
     * @Groups("mapping")
     */
    private string $category;

    /**
     * @var string//Sector
     *
     * @Groups("mapping")
     */
    private string $sector;

    /**
     * @var string
     *
     * @Groups("mapping")
     */
    private string $oid;

    /**
     * @var string
     *
     * @Groups("mapping")
     */
    private string $code;

    /**
     * @var string//Point
     *
     * @Groups("mapping")
     */
    private string $latitude;

    /**
     * @var string//Point
     *
     * @Groups("mapping")
     */
    private string $longitude;

    /**
     * @var \DateTimeInterface|null
     *
     * @Groups("mapping")
     */
    private ?\DateTimeInterface $updatedAt;

    /**
     * @var \DateTimeInterface
     *
     * @Groups("mapping")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @var array
     *
     * @Groups("mapping")
     */
    private array $objectProps;

    public function __construct()
    {
        $this->objectProps = [];
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array|ObjectProp[]
     */
    public function getObjectProps(): array
    {
        return $this->objectProps;
    }

    public function addObjectProp(ObjectProp $objectProp): self
    {
        $this->objectProps[] = $objectProp;
        $objectProp->setObject($this);

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getOid(): string
    {
        return $this->oid;
    }

    /**
     * @param string $oid
     */
    public function setOid(string $oid): void
    {
        $this->oid = $oid;
    }

    /**
     * @return string
     */
    public function getSector(): string
    {
        return $this->sector;
    }

    /**
     * @param string $sector
     */
    public function setSector(string $sector): void
    {
        $this->sector = $sector;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
