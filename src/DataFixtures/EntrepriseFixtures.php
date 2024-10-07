<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EntrepriseFixtures extends Fixture implements FixtureGroupInterface
{

    private const SERVICES = [
        'MARKETING',
        'DESIGN',
        'DEVELOPMENT',
        'SALES',
        'ACCOUNTING',
        'HR'
    ];

    public static function getGroups(): array
    {
        return [ 'migration20241005131831' ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 1) Créer mes entreprises
        // Pourquoi quand j'exécute le code sans commenter la partie 1) j'ai une erreur à la ligne 
        // 58 ($entreprise->addService($service) dans la partie 2) ) en me disant que $entreprise est null ?
        /*
        for ($i = 0; $i < count(self::SERVICES); $i++) {
            $entreprise = new Entreprise();
            $entreprise
                ->setNom($faker->company())
                ->setDescription($faker->text())
            ;

            $manager->persist($entreprise);
        }

        $manager->flush();
        */

        /**
         * 
         * Decomenter la partie 2) et 3) si l'état de la migration est la "Version20241005131831".
         * 
         * Attention: Il faut d'abord decommenter la partie 1) et executer une première la migration
         * avant d'exécuter la partie 2) et 3).
         * 
         */

        // 2) Ajouter un service à une entreprise.

        /*
        $serviceRepository = $manager->getRepository(Service::class);
        $entrepriseRepository = $manager->getRepository(Entreprise::class);
        $entreprises = $entrepriseRepository->findAll();
        
        for ($i = 0; $i < count(self::SERVICES); $i++) {
            $service = $serviceRepository->findByNom(self::SERVICES[$i])[0];
            $entreprise = $entreprises[$i];

            $entreprise->addService($service);
            $manager->persist($entreprise);
        }

        $manager->flush();
        */

        // 3) Ajouter les offres d'un service à une entreprise

        /*
        $entreprises = $entrepriseRepository->findAll();
        for ($i = 0; $i < count(self::SERVICES); $i++) {
            $service = $serviceRepository->findByNom(self::SERVICES[$i])[0];
            $entreprise = $entreprises[$i];

            $offres = $service->getOffres();

            foreach ($offres as $offre) {
                $entreprise->addOffre($offre);
            }

            $manager->persist($entreprise);
        }

        $manager->flush();
        */
    }
}
