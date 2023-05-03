<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class FileManagerInterface
{
    /**
     * Upload the file and return the temp file path
     *
     * @param UploadedFile $file
     * @return string
     */
    public abstract function uploadFile(UploadedFile $file): string;

    /**
     * @param string $filePath
     * @return array
     */
    public abstract function getFileHeaders(string $filePath): array;

    /**
     * @param Spreadsheet $phpExcel
     * @return Worksheet|null
     */
    public abstract function getWorkSheet(Spreadsheet $phpExcel): ?Worksheet;

    /**
     * @param string $tmpFilePath
     * @return array
     */
    public abstract function getDataFromExcelFile(string $tmpFilePath): array;
}
