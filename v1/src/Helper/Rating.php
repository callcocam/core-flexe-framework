<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * Date: 16/07/2018
 * Time: 23:31
 */

namespace Flexe\Helper;


class Rating extends AbstractHelper
{
    /**
     * @var \App\Admin\Model\Rating
     */
    protected $model = \App\Admin\Model\Rating::class;

    private function ratings(){

        return $this->model->from();
    }

    /**
     *
     * @param $filter
     * @return mix
     */
    public function avgRating($filter)
    {
        return $this->ratings()->select(null)->select('AVG(rating) as media')->where($filter)->fetchColumn();

    }

    /**
     *
     * @param $filter
     * @return mix
     */
    public function sumRating($filter)
    {
        return $this->ratings()->select(null)->select('SUM(rating) as total')->where($filter)->fetchColumn();
    }

    /**
     * @param $filter
     * @param null $total
     * @param int $max
     *
     * @return float|int
     */
    public function ratingPercent($filter,$max = 5)
    {
        $quantity = $this->ratings()->where($filter)->count();
        $total = $this->sumRating($filter);
        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    /**
     * @param $quantity
     * @param null $total
     * @param int $max
     *
     * @return float|int
     */
    public function ratingPercentTotal($quantity,$total,$max = 5)
    {
        if($quantity && $total):
            return ($quantity * $max) > 0 ? ($total / (($quantity * $max) / 100) * $max) : 0;
        else:
            return 0;
        endif;
    }

    /**
     *
     * @param $filter
     * @return mix
     */
    public function countPositive($filter)
    {
        return $this->ratings()->where($filter)->where('rating > ?', '0')->count();
    }

    /**
     *
     * @param $filter
     * @return mix
     */
    public function countNegative($filter=[])
    {
        $quantity = $this->ratings()->where($filter)->where('rating < ?', '0')->count();
        return ("-$quantity");
    }

}