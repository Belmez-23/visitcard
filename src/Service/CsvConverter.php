<?php

namespace App\Service;

/**
 * Самодельный CSV-конвертер.
 * Пробовала league/csv, но каким-то образом очистился csv-файл и я недоумевала - почему класс ругается на отсутствие данных
 */
class CsvConverter
{
    public function get($filename)
    {
        $csvData = file_get_contents($filename);
        $lines = explode(PHP_EOL, $csvData);
        $data = [];
        foreach ($lines as $line) {
            $data[] = str_getcsv($line);
        }
        $header = array_shift($data);
        foreach ($data as $item) {
            if (count($item) == count($header)) {
                $result[] = array_combine($header, $item);
            }
        }

        return $result ?? [];
    }

    public function set($filename, $data)
    {
        $header = array_keys($data[0]);
        array_unshift($data, $header);

        $fp = fopen($filename, 'w'); // open in write only mode (write at the start of the file)
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }

        fclose($fp);
    }

    public function add($path, $row)
    {
        $fp = fopen($path, 'a'); // open in write only mode (with pointer at the end of the file)

        fputcsv($fp, $row);

        fclose($fp);
    }
}