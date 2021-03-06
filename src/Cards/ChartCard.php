<?php

namespace Sanjab\Cards;

use stdClass;
use Sanjab\Helpers\ChartData;

/**
 * Chart card.
 *
 * @method $this chartTag(string $val)      tag of chart.
 * @method $this labels(array $val)         array of chart labels.
 * @method $this height(int $height)        height of chart.
 * @method $this borderless(bool $val)      by default is true. if you want a border around card set this to false.
 */
class ChartCard extends Card
{
    /**
     * Data array.
     *
     * @var ChartData[]
     */
    protected $chartData = [];

    public function init()
    {
        $this->tag('chart-card');
        $this->height(128);
        $this->cols(6);
    }

    protected function modifyResponse(stdClass $response)
    {
        $chartData = $this->chartData;
        foreach ($chartData as $key => $data) {
            if (is_callable($data->property('data'))) {
                $chartData[$key]->setProperty('data', ($data->property('data'))());
            }
        }
        $response->data = $chartData;
    }

    /**
     * Add a chart data to dataset.
     *
     * @param ChartData $chartData
     * @return $this
     */
    public function addData(ChartData $chartData)
    {
        $this->chartData[] = $chartData;

        return $this;
    }

    /**
     * Add array of chart data to dataset.
     *
     * @param ChartData ...$chartData
     * @return $this
     */
    public function addMultipleData(ChartData ...$chartData)
    {
        $this->chartData = array_merge($this->chartData, ...$chartData);

        return $this;
    }
}
