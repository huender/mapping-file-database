<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FileManager extends FileManagerInterface
{
    /**
     * Upload the file and return the temp file path
     *
     * @param $file
     * @return string
     */
    public function uploadFile($file): string
    {
        // Process the uploaded file and store it in a temporary location
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'uploaded_file');
        $file->move(dirname($tmpFilePath), basename($tmpFilePath));

        return $tmpFilePath;
    }

    /**
     * @param string $filePath
     * @return array
     */
    public function getFileHeaders(string $filePath): array
    {
        // Get the file headers to used it in the front-end
        $phpExcel = IOFactory::load($filePath);

        // TODO test without sheet
        if (!empty($phpExcel->getSheetNames())) {
            $worksheet = $this->getWorkSheet($phpExcel);

            return array_filter($worksheet->toArray()[0], function($value){
                return !is_null($value);
            });
        }

        return [];
    }

    /**
     * @param Spreadsheet $phpExcel
     * @return Worksheet|null
     */
    public function getWorkSheet(Spreadsheet $phpExcel): ?Worksheet
    {
        return $phpExcel->getSheetByName($phpExcel->getSheetNames()[0]);
    }

    /**
     * @param string $tmpFilePath
     * @return array
     */
    public function getDataFromExcelFile(string $tmpFilePath): array
    {
        $phpExcel = IOFactory::load($tmpFilePath);

        return $this->getWorkSheet($phpExcel)->toArray();
    }
}
