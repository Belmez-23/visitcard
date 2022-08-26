<?php

namespace App\Service;

class BaseService
{
    public function getResume()
    {
        $array = [
            'Кто я' => 'cccc',
            'Что я могу' => 'ccccc',
            'Мой опыт' => 'cccc',
        ];

        return array_map(function ($header, $text) {
            return array(
                'header' => $header,
                'text' => $text,
            );
        }, array_keys($array), $array);
    }
}