<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */


namespace Flexe\Plugins\ChartJS;


class ChartJS
{
    /**
     * @var array chart data
     */
    protected $data = [];

    /**
     * The chart type
     * @var string
     */
    protected $type = '';

    /**
     * @var array Specific options for chart
     */
    protected $options = [];

    protected $colors = [];

    protected $datasets = [];

    /**
     * @var array Canvas html attributes
     */
    protected $attributes = [
        'id' =>'example',
        'width' => 1000,
        'class' => "embed-responsive-item",
        'height' => 500,
        'style' => 'display:inline;'
    ];

    public function __construct($type = 'line', $data = [], $options = [], $attributes = [])
    {
        $this->type = $type;
        $this->data = $data;
        $this->options = $options;

        // Always save attributes as array
        if ($attributes && !is_array($attributes)) {
            $attributes = [$attributes];
        }

        $this->attributes = $attributes;
    }

    /**
     * This method allows to echo ChartJS object and directly renders canvas (instead of using ChartJS->render())
     */
    public function __toString()
    {
        return $this->renderCanvas();
    }

    public function renderCanvas()
    {
        $renderedData = $this->renderData();
        $renderedOptions = $this->renderOptions();
        $renderedAttributes = $this->renderAttributes();
        $canvas = "<canvas$renderedAttributes data-chartjs='" . $this->type . "' $renderedData $renderedOptions></canvas>";

        return $canvas;
    }

    /**
     * Add a set of data
     * @param array $dataset
     */
    public function addDataset($dataset)
    {
        $this->data['datasets'][] = $dataset;
    }

    /**
     * Prepare canvas' attributes
     * @return string
     */
    private function renderAttributes()
    {

        $attributes = '';
        if (!isset($this->attributes['id'])) {
            $this->attributes['id'] = uniqid('chartjs_', true);
        }

        foreach ($this->attributes as $attribute => $value) {
            $attributes .= ' ' . $attribute . '="' . $value . '"';
        }

        return $attributes;
    }

    protected function rgba(){
        $color = sprintf('rgba(%s, %s, %s, 1)',rand(1,255),rand(1,255),rand(1,255));
        return $color;

    }
    /**
     * Render custom options for the chart
     * @return string
     */
    private function renderOptions()
    {
        if (empty($this->options)) {
            return 'data-options=\'null\'';
        }
        return 'data-options=\'' . json_encode($this->options) . '\'';
    }

    /**
     * Prepare data (labels and dataset) for the chart
     * @return string
     */
    private function renderData()
    {
        if (empty($this->data)) {
            return 'data-data=\'null\'';
        }
        return 'data-data=\'' . json_encode($this->data) . '\'';
    }
}