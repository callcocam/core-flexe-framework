<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * Date: 16/07/2018
 * Time: 23:25
 */

namespace App\Admin\Model;



use Flexe\Model\AbstractModel;

class Rating extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'ratings';

    /**
     * @var array
     */
    protected $fillable = ['rating', 'users_id' , 'parent_id' ,  'assets' , 'status' , 'created_at', 'updated_at'];


}