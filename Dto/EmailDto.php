<?php

namespace Carlosv2\HermesBundle\Dto;

class EmailDto
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var integer
     */
    public $date;

    /**
     * @var array
     */
    public $content;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var AddressDto[]
     */
    public $from;

    /**
     * @var AddressDto[]
     */
    public $to;

    /**
     * @var AddressDto[]
     */
    public $cc;

    /**
     * @var AddressDto[]
     */
    public $bcc;

    /**
     * @param \Swift_Mime_Message $message
     *
     * @return EmailDto
     */
    public static function fromSwiftMimeMessage(\Swift_Mime_Message $message)
    {
        $dto = new self();

        $dto->id = $message->getId();
        $dto->date = $message->getDate();

        $dto->from = self::processAddresses($message->getFrom());
        $dto->to = self::processAddresses($message->getTo());
        $dto->cc = self::processAddresses($message->getCc());
        $dto->bcc = self::processAddresses($message->getBcc());

        $dto->subject = $message->getSubject();
        $dto->content = [
            'text' => $message->getBody(),
            'html' => $message->getBody()
        ];

        return $dto;
    }

    /**
     * @param array $addresses
     *
     * @return AddressDto[]
     */
    private static function processAddresses(array $addresses)
    {
        $addressDtos = [];
        foreach ($addresses as $address => $name) {
            $addressDtos[] = AddressDto::fromAddressAndName($address, $name);
        }

        return $addressDtos;
    }
}
