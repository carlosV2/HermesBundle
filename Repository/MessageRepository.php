<?php

namespace Carlosv2\HermesBundle\Repository;

use Everzet\PersistedObjects\AccessorObjectIdentifier;
use Everzet\PersistedObjects\FileRepository;

class MessageRepository
{
    /**
     * @var
     */
    private $repository;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->repository = new FileRepository($path, new AccessorObjectIdentifier('getId'));
    }

    /**
     * @return \Swift_Mime_Message[]
     */
    public function loadAll()
    {
        return $this->repository->getAll();
    }

    /**
     * @param \Swift_Mime_Message $message
     */
    public function save(\Swift_Mime_Message $message)
    {
        $this->repository->save($message);
    }
}
