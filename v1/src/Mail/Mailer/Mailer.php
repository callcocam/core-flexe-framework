<?php

namespace Flexe\Mail\Mailer;

use Flexe\Mail\Interfaces\MailableInterface;
use Flexe\Views\View;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Class Mailer.
 */
class Mailer
{
    /** @var string */
    protected $host = 'localhost';

    /** @var int */
    protected $port = 25;

    /** @var string */
    protected $username = '';

    /** @var string */
    protected $password = '';

    /** @var string */
    protected $from = [];

    /** @var Swift_Mailer */
    protected $swiftMailer;

    /** @var View */
    protected $render;

    /** @var string */
    protected $protocol = null;

    /**
     * @param View  $render
     * @param array $settings optional
     */
    public function __construct(View $render, array $settings = [])
    {
        // Parse the settings, update the mailer properties.
        foreach ($settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        $transport = new Swift_SmtpTransport($this->host, $this->port, $this->protocol);
        $transport->setUsername($this->username);
        $transport->setPassword($this->password);

        $this->swiftMailer = new Swift_Mailer($transport);
        $this->render = $render;
    }

    /**
     * @param string $address
     * @param string $name    optional
     *
     * @return $this
     */
    public function setDefaultFrom(string $address, string $name = '')
    {
        $this->from = compact('address', 'name');

        return $this;
    }

    /**
     * @param mixed    $view
     * @param array    $data     optional
     * @param callable $callback optional
     *
     * @return int
     */
    public function sendMessage($view, array $data = [], callable $callback = null)
    {
        if ($view instanceof MailableInterface) {
            return $view->sendMessage($this);
        }

        $message = new MessageBuilder(new Swift_Message());
        $message->setFrom($this->from['address'], $this->from['name']);

        if ($callback) {
            call_user_func($callback, $message);
        }
        $this->render->setPath(sprintf("%s/src/views/", dirname(__DIR__, 4)));

        $message->setBody($this->render->partial($view, $data));

        return $this->swiftMailer->send($message->getSwiftMessage());
    }

    /**
     * @param string $address
     * @param string $name    optional
     *
     * @return PendingMailable
     */
    public function setTo(string $address, string $name = '')
    {
        return (new PendingMailable($this))->setTo($address, $name);
    }
}
