<?php

namespace Carlosv2\HermesBundle\Dto;

class AddressDto
{
    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $name;

    /**
     * @param string $address
     * @param string $name
     *
     * @return AddressDto
     */
    public static function fromAddressAndName($address, $name)
    {
        $dto = new self();

        $dto->address = $address;
        $dto->name = $name;

        return $dto;
    }
}
