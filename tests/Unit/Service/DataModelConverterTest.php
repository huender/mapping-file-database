<?php

namespace App\Tests\Unit\Service;

use App\Entity\Objects;
use App\Model\MappingDTO;
use App\Model\MappingPostRequestDTO;
use App\Service\DataModelConverter;
use App\Service\FileManagerInterface;
use PHPUnit\Framework\TestCase;

class DataModelConverterTest extends TestCase
{
    public function testMappingSuccess()
    {
        $mapping = [
            new MappingDTO("column_1", "property_1"),
            new MappingDTO("column_2", "property_2")
        ];

        $mappingPostRequest = new MappingPostRequestDTO("random_file_path", "type", $mapping);

        $fileManager = $this->createMock(FileManagerInterface::class);
        $fileManager
            ->expects($this->once())
            ->method("getDataFromExcelFile")
            ->with("random_file_path")
            ->willReturn([["property_1", "property_2"], ["value_1", "value_2"], ["value_3", "value_4"]]);

        $dataModelConverter = new DataModelConverter($fileManager);

        $feedback = $dataModelConverter->saveMapping($mappingPostRequest);

        $this->assertCount(2, $feedback);
        $this->assertInstanceOf(Objects::class, $feedback[0]);
        $this->assertInstanceOf(Objects::class, $feedback[1]);

        /** @var Objects $object */
        foreach ($feedback as $object) {
            $this->assertSame("type", $object->getType());
            $this->assertCount(2, $object->getObjectProps());
        }
    }

    public function testMappingWithoutFileData()
    {
        $mapping = [
            new MappingDTO("column_1", "property_1"),
            new MappingDTO("column_2", "property_2")
        ];

        $mappingPostRequest = new MappingPostRequestDTO("random_file_path", "type", $mapping);

        $fileManager = $this->createMock(FileManagerInterface::class);
        $fileManager
            ->expects($this->once())
            ->method("getDataFromExcelFile")
            ->with("random_file_path")
            ->willReturn([["property_1", "property_2"]]);

        $this->assertEmpty((new DataModelConverter($fileManager))->saveMapping($mappingPostRequest));
    }


    public function testMappingWithoutMapping()
    {
        $mappingPostRequest = new MappingPostRequestDTO("random_file_path", "type", []);
        $fileManager = $this->createMock(FileManagerInterface::class);

        $fileManager
            ->expects($this->once())
            ->method("getDataFromExcelFile")
            ->with("random_file_path")
            ->willReturn([["property_1", "property_2"]]);

        $this->assertEmpty((new DataModelConverter($fileManager))->saveMapping($mappingPostRequest));
    }
}
