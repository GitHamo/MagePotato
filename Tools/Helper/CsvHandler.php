<?php
/**
 * * Copyright © Magepotato. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepotato\Tools\Helper;

use League\Csv\Writer;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvHandler
{
    public function write(array $header, array $contents)
    {
        $writer = Writer::createFromFileObject(new \SplTempFileObject()); //the CSV file will be created using a temporary File
        $writer->setNewline("\r\n"); //use windows line endings for compatibility with some csv libraries
        $writer->setOutputBOM(Writer::BOM_UTF8); //adding the BOM sequence on output
        $writer->insertOne($header);
        $writer->insertAll($contents);
        return $writer;
    }

    public function read($file)
    {
        $csv = Reader::createFromFileObject(new \SplFileObject($file['tmp_name']));
        $csv->setHeaderOffset(0); //set the CSV header offset
        $stmt = (new Statement());
        $records = $stmt->process($csv);
        return $records;
    }
}
