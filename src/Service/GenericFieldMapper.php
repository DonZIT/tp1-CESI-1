<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\MapperInterface;
use Doctrine\Common\Collections\ReadableCollection;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

class GenericFieldMapper implements MapperInterface
{
    public function map(object $source, object $target): void
    {
        $reflectionExtractor = new ReflectionExtractor();
        $sourceProperties = $reflectionExtractor->getProperties($source::class);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($sourceProperties as $propertyName) {
            if ($propertyAccessor->isWritable($target, $propertyName) && $propertyAccessor->isReadable($source, $propertyName)) {
                $value = $propertyAccessor->getValue($source, $propertyName);

                if ($value instanceof ReadableCollection) {
                    $value = $value->toArray();
                }

                $propertyAccessor->setValue($target, $propertyName, $value);
            }
        }
    }
}
