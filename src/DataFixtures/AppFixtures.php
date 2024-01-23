<?php

namespace App\DataFixtures;

use App\Entity\Pizza;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pizzas = [
            ['PEP', 'Pépéroni', 12.50],
            ['MAR', 'Margherita', 14.00],
            ['REIN', 'La Reine', 11.50],
            ['FRO', 'La 4 fromages', 12.00],
            ['CAN', 'La cannibale', 12.50],
            ['SAV', 'La savoyarde', 13.00],
            ['ORI', 'L’orientale', 13.50],
            ['IND', 'L’indienne', 14.00],
        ];

        foreach ($pizzas as $data) {
            $pizza = new Pizza();
            $pizza->setShortcut($data[0]);
            $pizza->setName($data[1]);
            $pizza->setPrice($data[2]);

            $manager->persist($pizza);
        }

        $manager->flush();
    }
}
