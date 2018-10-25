<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 10/09/2018
 * Time: 22:35
 */

namespace Mail;


use Flexe\Model\AbstractModel;
use Illuminate\Mail\Mailable;

class AbstractMail extends Mailable
{

    /**
     * The order instance.
     *
     * @var AbstractModel
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AbstractModel $order)
    {
        $this->order = $order;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.shipped');
    }
}