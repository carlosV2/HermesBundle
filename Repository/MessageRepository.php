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
        $this->ensurePathExists(dirname($path));

        $this->repository = new FileRepository($path, new AccessorObjectIdentifier('getId'));
    }

    /**
     * @param string $path
     */
    private function ensurePathExists($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
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
