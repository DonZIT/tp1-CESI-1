<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Pizza;
use App\Dto\AbstractDto;

use Symfony\Component\Validator\Constraints as Assert;

class PizzaBaseDto extends AbstractDto
{
    #[Assert\NotBlank]
    public ?string $name = null;

    public ?float $price = null;

    protected function getEntityClass(): string
    {
        return Pizza::class;
    }
}
