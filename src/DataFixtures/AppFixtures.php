<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $chrono = 1;

        for($i = 0; $i < 30; $i++)
        {
            $customer = new Customer();
            $customer->setFirstName($faker->firstName())
                     ->setLastName($faker->lastName())
                     ->setCompany($faker->company())
                     ->setEmail($faker->email());

            $manager->persist($customer);

            for($j = 0; $j < mt_rand(3,10); $j++)
            {
                $invoice = new Invoice();
                $invoice->setAmout($faker->randomFloat(2,250, 5000))
                        ->setSentAt($faker->dateTimeBetween('-6 months'))
                        ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                        ->setCustomer($customer)
                        ->setChrono($chrono);

                $chrono ++;

                $manager->persist($invoice);
            }
        }

        $manager->flush();
    }
}
