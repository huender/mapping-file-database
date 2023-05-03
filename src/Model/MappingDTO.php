<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class MappingDTO
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public string $columnName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $propertyName;

    public function __construct(
        string $column_name,
        string $property_name
    )
    {
        $this->columnName = $column_name;
        $this->propertyName = $property_name;
    }
}
