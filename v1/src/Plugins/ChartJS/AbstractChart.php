<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace Flexe\Plugins\ChartJS;


abstract class AbstractChart
{
    /**
     * @var array chart data
     */
    protected $data =  [
        'labels' => [],
        'datasets' => []
    ];

    /**
     * The chart type
     * @var string
     */
    protected $type = 'line';

    /**
     * @var array Specific options for chart
     */
    protected $options = ['responsive' => true];

    protected $colors = [];

    protected $datasets = [];

    /**
     * @var array Canvas html attributes
     */
    protected $attributes = [
        'id' =>'example',
        'width' => 1000,
        'height' => 500,
        'style' => 'display:inline;'];


    /**
     * @param array $data
     * @return $this
     */
    abstract public function setData(array $data =[]);

    /**
     * @param string $type
     * @return  $this
     */
    abstract public function setType(string $type="");

    /**
     * @param array $options
     * @return ChartJS
     */
    abstract public function setOptions(array $options=[]);

    /**
     * @param array $colors
     * @return  $this
     */
    abstract public function setColors(array $colors=[]);
    /**
     * @param array $datasets
     * @return  $this
     */
    abstract public function setDatasets(array $datasets =[]);

    /**
     * @param array $attributes
     * @return  $this
     */
    abstract public function setAttributes(array $attributes =[]);
}