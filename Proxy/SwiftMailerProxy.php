<?php

namespace Carlosv2\HermesBundle\Proxy;

class SwiftMailerProxy extends \Swift_Mailer
{
    /**
     * {@inheritdoc}
     */
    public function __construct(\Swift_Transport $transport)
    {
        parent::__construct($transport);
    }

    /**
     * {@inheritdoc}
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        return parent::send($message, $failedRecipients);
    }
}
