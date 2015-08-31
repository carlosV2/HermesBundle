<?php

namespace Carlosv2\HermesBundle\Dto;

class EmailDto
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $message;

    public static function fromSwiftMimeMessage(\Swift_Mime_Message $message)
    {
        $dto = new self();

        $dto->id = $message->getId();
        $dto->message = $message->toString();

        return $dto;
    }
}
