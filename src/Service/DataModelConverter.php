<?php

namespace App\Service;

use App\Entity\ObjectProp;
use App\Entity\Objects;
use App\Entity\Fields;
use App\Model\MappingPostRequestDTO;

class DataModelConverter
{
    private FileManagerInterface $fileManager;

    /**
     * @param FileManagerInterface $fileManager
     */
    public function __construct(FileManagerInterface $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function saveMapping(MappingPostRequestDTO $mappingPostRequest): array
    {
        // Extract the data from the specified worksheet
        $data = $this->fileManager->getDataFromExcelFile($mappingPostRequest->filePath);

        $mappedData = $this->mapColumns($mappingPostRequest, $data);

        $total = [];

        foreach ($mappedData as $row) {
            //@TODO find the correct object or create if doesnt exists
            $object = new Objects();
            $object->setType($mappingPostRequest->objectType);

            foreach ($row as $propName => $propValue) {
                //@TODO find the correct field mapped to fill the props values or create if doesnt exists
                $fields = new Fields();
                $fields->setName($propName);

                $objectProp = new ObjectProp();
                $objectProp->setFields($fields);

                $objectProp->setValue($propValue);
                $object->addObjectProp($objectProp);
            }
            $total[] = $object;
        }

        return $total;
    }

    /**
     * Map the columns according the mapping
     *
     * @param MappingPostRequestDTO $mappingPostRequest
     * @param array $data
     * @return array
     */
    private function mapColumns(MappingPostRequestDTO $mappingPostRequest, array $data): array
    {
        // Map the columns from the uploaded file to the database fields
        $mappedData = [];
        $headers = [];
        foreach ($data as $key => $row) {
            if ($key == 0) {
                // Organize the file header
                foreach ($row as $k => $item) {
                    if ($item){
                        $headers[$item] = $k;
                    } else {
                        break;
                    }
                }
                continue;
            }

            if (is_null($row[0])) {
                break;
            }

            $mappedRow = [];

            //Map the columns
            foreach ($mappingPostRequest->mapping as $columnMapping) {
                $mappedRow[$columnMapping->columnName] = $row[$headers[$columnMapping->propertyName]];
            }

            $mappedData[] = $mappedRow;
        }

        return $mappedData;
    }
}
