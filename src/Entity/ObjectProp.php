<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class ObjectProp
{
    private ?Objects $object;

    /**
     * @var Fields
     *
     * @Groups("mapping")
     */
    private Fields $fields;

    /**
     * @var string
     *
     * @Groups("mapping")
     */
    private string $value;

    public function getObject(): ?Object
    {
        return $this->object;
    }

    public function setObject(?Object $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getFields(): ?Fields
    {
        return $this->fields;
    }

    public function setFields(?Fields $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
