<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class MappingPostRequestDTO
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public string $filePath;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public string $objectType;

    /**
     * @var MappingDTO[]
     */
    public array $mapping;

    public function __construct(
        string $file_path,
        string $object_type,
        array $mapping
    )
    {
        $this->filePath = $file_path;
        $this->objectType = $object_type;
        $this->mapping = $mapping;
    }
}
