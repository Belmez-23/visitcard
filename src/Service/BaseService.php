<?php

namespace App\Service;

class BaseService
{
    public static function numberDeclination($n, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);

        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }

    public function getResume()
    {
        $howOldAmINow = (new \DateTime())->diff(new \DateTime('1998-12-23'))->y;
        $howOldAmINow .= ' ' . self::numberDeclination($howOldAmINow, ['год', 'года', 'лет']);
        /* Скопировано с резюме на хх
        TODO: расписать поинтереснее */
        $array = [
            ['header' => 'Кто я',
                'text' => 'Женщина, ' . $howOldAmINow . ', родилась 23 декабря 1998. Вредных привычек не имею.',
                'sticker' => 'flow1.png'],
            ['header' => 'Что я могу',
                'text' => 'Быстро обучаюсь новому, честно и ответственно подхожу к работе. ',
                'sticker' => 'flow2.png'],
            ['header' => 'Мой опыт',
                'text' => 'Занимаюсь back-end-разработками в компании Джейкет.ру. ',
                'sticker' => 'flow3.png'],
        ];

        return $array;
    }
}