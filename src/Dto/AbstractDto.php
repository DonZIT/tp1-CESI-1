<?php

declare(strict_types=1);

namespace App\Dto;

use App\Dto\DtoInterface;
use App\Service\GenericFieldMapper;

abstract class AbstractDto implements DtoInterface
{
    protected object $entity;

    abstract protected function getEntityClass(): string;

    public function __construct(?object $entity = null)
    {
        if ($entity) {
            $this->entity = $entity;

            $this->map($this->entity, $this);

            static::afterInstantiate($entity, $this);
        }
    }

    protected function getEntity(): object
    {
        return $this->entity ?? new ($this->getEntityClass());
    }

    protected static function afterInstantiate(object $entity, object $dto): void
    {
    }

    protected static function afterMap(object $dto, object $entity): void
    {
    }

    protected function map(object $source, object $target): void
    {
        $mapper = new GenericFieldMapper();
        $mapper->map($source, $target);
    }

    public function entity(): object
    {
        $entity = $this->getEntity();
        $this->map($this, $entity);

        static::afterMap($this, $entity);

        return $entity;
    }
}
