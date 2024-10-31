<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Dette;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class ClientFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 50; $i++) {
            $client = new Client();
            $client->setUsername('Client '.$i);
            $client->setTelephone('06 00 00 00 '.$i);
            $client->setAddress('Address '.$i);
            if ($i % 2 == 0) {
                $user = new User();
                $user->setNom('Nom '.$i);
                $user->setPrenom('Prenom '.$i);
                $user->setLogin('Login '.$i);
                $plaintedPassword = "Password ";
                $hashedPassword = $this->encoder->hashPassword($user, $plaintedPassword);
                $user->setPassword($hashedPassword);
                $user->setClient($client);
                $client->setUsers($user);
                $manager->persist($user);
                for ($j=0; $j < 2; $j++) {
                    $dette = new Dette();
                    $dette->setMontant(15000 * $j);
                    $dette->setMontantVerser(15000 * $j);
                    $dette->setClient($client);
                    $client->addDette($dette);
                    $manager->persist($dette);
                }
            } else {
                for ($j=0; $j < 2; $j++) {
                    $dette = new Dette();
                    $dette->setMontant(15000 * $j);
                    $dette->setMontantVerser(15000);
                    $dette->setClient($client);
                    $client->addDette($dette);
                    $manager->persist($dette);
                }
            }
            $manager->persist($client);
        }

        $manager->flush();
    }
}
