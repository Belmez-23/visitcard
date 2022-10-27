<?php

namespace App\Service;

class Lift
{
    /** @var string Вещи для поднятия */
    private $items = __DIR__ . '/../Pseudoentity/lift_item.csv';
    /** @var string История поднятий */
    private $history = __DIR__ . '/../Pseudoentity/lift_history.csv';
    /** @var string Рейтинговая таблица */
    private $chart = __DIR__ . '/../Pseudoentity/lift_chart.csv';

    /** @var CsvConverter */
    private $csv;

    public function __construct()
    {
        $this->csv = new CsvConverter();
    }

    public function getItems()
    {
        return $this->csv->get($this->items);
    }

    public function getHistory()
    {
        return $this->csv->get($this->history);
    }

    public function getLastHistoryId()
    {
        return array_keys($this->getHistory())[count($this->getHistory()) - 1];
    }

    public function getChart()
    {
        return $this->csv->get($this->chart);
    }

    public function getItemsList()
    {
        $items = $this->getItems();

        foreach ($items as $item) {
            $result[$item['id']] = $item['label'];
        }

        return $result ?? [];
    }

    public function getHistoryList()
    {
        $items = $this->getItems();
        $history = $this->getHistory();

        $totalWeight = 0;
        foreach ($history as &$row) {
            $row['itemLabel'] = $items[$row['item']]['label'];
            $row['totalWeightLifted'] = $row['reps'] * $items[$row['item']]['weight'];
            $totalWeight += $row['totalWeightLifted'];
        }

        return ['repLogs' => $history, 'totalWeight' => $totalWeight, 'leaderboard' => $this->getChart()];
    }

    public function addToHistory($row)
    {
        $row['id'] = $this->getLastHistoryId() + 1;

        $this->csv->add($this->history, $row);
    }

    public function deleteFromHistory($id)
    {
        $history = $this->getHistory();
        foreach ($history as $key => $row) {
            if ($row['id'] == $id) {
                unset($history[$key]);
                $this->csv->set($this->history, $history);

                return true;
            }
        }

        return false;
    }
}