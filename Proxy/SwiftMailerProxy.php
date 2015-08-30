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
     * @var bool
     */
    private $keepCopy;

    /**
     * @var bool
     */
    private $preventDelivery;

    /**
     * @param \Swift_Transport  $transport
     * @param MessageRepository $repository
     * @param bool              $keepCopy
     * @param bool              $preventDelivery
     */
    public function __construct(\Swift_Transport $transport, MessageRepository $repository, $keepCopy, $preventDelivery)
    {
        $this->repository = $repository;
        $this->keepCopy = $keepCopy;
        $this->preventDelivery = $preventDelivery;

        parent::__construct($transport);
    }

    /**
     * {@inheritdoc}
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        if ($this->keepCopy) {
            $this->repository->save($message);
        }

        if ($this->preventDelivery) {
            return parent::send($message, $failedRecipients);
        }
    }
}
