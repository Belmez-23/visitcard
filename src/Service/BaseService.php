<?php

namespace App\Service;

class BaseService
{
    public function getResume()
    {
        $howOldAmINow = (new \DateTime())->diff(new \DateTime('1998-12-23'))->y;
        /* Скопировано с резюме на хх
        TODO: расписать поинтереснее */
        $array = [
            'Кто я' => 'Женщина, ' . $howOldAmINow . ' года, родилась 23 декабря 1998. Вредных привычек не имею.',
            'Что я могу' => 'Быстро обучаюсь новому, честно и ответственно подхожу к работе. ',
            'Мой опыт' => 'Занимаюсь back-end-разработками в компании Джейкет.ру. ',
        ];

        return array_map(function ($header, $text) {
            return array(
                'header' => $header,
                'text' => $text,
            );
        }, array_keys($array), $array);
    }
}