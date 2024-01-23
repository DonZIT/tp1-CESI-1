<?php

namespace App\Service;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;

class PizzaManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPizza(string $name, float $price): Pizza
    {
        $pizza = new Pizza();
        $pizza->setName($name);
        $pizza->setPrice($price);

        $shortcut = $this->generateShortcutFromName($name);
        $pizza->setShortcut($shortcut);

        $this->entityManager->persist($pizza);
        $this->entityManager->flush();

        return $pizza;
    }

    public function updatePizza(Pizza $pizza, ?string $name, ?float $price): Pizza
    {
        if ($name !== null) {
            $pizza->setName($name);
            $shortcut = $this->generateShortcutFromName($name);
            $pizza->setShortcut($shortcut);
        }

        if ($price !== null) {
            $pizza->setPrice($price);
        }

        $this->entityManager->flush();

        return $pizza;
    }

    public function deletePizza(Pizza $pizza): void
    {
        $this->entityManager->remove($pizza);

        $this->entityManager->flush();
    }

    public function generateShortcutFromName(string $name): string
    {
        $nameParts = explode(' ', $name);

        if (count($nameParts) == 1 && strlen($nameParts[0]) >= 3) {
            // Pour un seul mot long, prendre les trois premières lettres
            $shortcut = strtoupper(substr($nameParts[0], 0, 3));
        } else {
            // Sinon, suivre la logique existante
            $shortcut = '';
            foreach ($nameParts as $word) {
                $shortcut .= strtoupper(substr($word, 0, 1));
            }
            if (strlen($shortcut) > 3) {
                $shortcut = substr($shortcut, 0, 3);
            }
        }

        return $shortcut;
    }
}
