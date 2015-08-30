<?php

namespace Carlosv2\HermesBundle\Proxy;

use Carlosv2\HermesBundle\Repository\MessageRepository;

class SwiftMailerProxy extends \Swift_Mailer
{
    /**
     * @var MessageRepository
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(\Swift_Transport $transport, MessageRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct($transport);
    }

    /**
     * {@inheritdoc}
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->repository->save($message);

        return parent::send($message, $failedRecipients);
    }
}
