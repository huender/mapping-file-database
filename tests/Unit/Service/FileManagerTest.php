<?php

namespace App\Tests\Unit\Service;

use App\Service\FileManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerTest extends TestCase
{
    public function testUploadFileSuccess()
    {
        $file = $this->createMock(UploadedFile::class);
        $filePath = (new FileManager())->uploadFile($file);

        $file->method("move")->willReturn($this->createMock(File::class));

        $this->assertIsString($filePath);
    }

    public function testUploadError()
    {
        $this->expectException(FileException::class);

        $file = $this->createMock(UploadedFile::class);
        $file->method("move")->willThrowException(new FileException());

        (new FileManager())->uploadFile($file);
    }

    public function testGetFileHeaders()
    {
        $filePath = '/tmp/file.xlsx';
        fopen($filePath, 'w');

        $expectedHeaders = ['Header 1', 'Header 2', 'Header 3', 'Header 4'];

        $testData = [
            ['Header 1', 'Header 2', 'Header 3', 'Header 4'],
            ['Data 1', 'Data 2', 'Data 3', 'Data 4']
        ];

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($testData);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $this->assertEquals($expectedHeaders, (new FileManager())->getFileHeaders($filePath));

        unlink($filePath);
    }

    public function testGetFileHeadersEmpty()
    {
        $filePath = '/tmp/file.xlsx';
        fopen($filePath, 'w');

        $testData = [
            [],
            ['Data 1', 'Data 2', 'Data 3', 'Data 4']
        ];

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($testData);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $this->assertEquals([], (new FileManager())->getFileHeaders($filePath));

        unlink($filePath);
    }
}
