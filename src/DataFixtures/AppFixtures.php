<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Offre;
use App\Entity\Service;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const TAGS = [
        'PHP',
        'SYMFONY',
        'LARAVEL',
        'JS',
        'REACT',
        'VUE',
        'ANGULAR',
        'SQL',
        'POSTGRESQL'
    ];

    private const SERVICES = [
        'MARKETING',
        'DESIGN',
        'DEVELOPMENT',
        'SALES',
        'ACCOUNTING',
        'HR'
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::TAGS as $tagName) {
            $manager->persist($this->createTag($tagName));
        }

        foreach (self::SERVICES as $serviceName) {
            $manager->persist(
                $this->createService(
                    $serviceName,
                    $faker->phoneNumber(),
                    $faker->email()
                )
            );
        }

        $manager->flush();

        for ($i = 0; $i < count(self::SERVICES); $i++) {
            $entreprise = $this->createEntreprise(
                $faker->company(),
                $faker->text(),
                $manager
            );

            $manager->persist($entreprise);
        }

        $manager->flush();

        for ($i = 0; $i < 25; $i++) {
            $offre = $this->createOffre(
                $faker->jobTitle(),
                $faker->paragraph(3),
                $faker->randomFloat(6, 0, 9999),
                $this->randomEntreprise($manager),
                $this->randomTags($manager)
            );

            $manager->persist($offre);
        }

        $manager->flush();
    }

    private function createService(string $nom, string $telephone, string $email): Service
    {
        $service = new Service();
        $service
            ->setNom($nom)
            ->setTelephone($telephone)
            ->setEmail($email)
        ;

        return $service;
    }

    private function createTag(string $nom): Tag
    {
        $tag = new Tag();
        $tag->setNom($nom);

        return $tag;
    }

    private function createEntreprise(string $nom, string $description, ObjectManager $manager): Entreprise
    {
        $entreprise = new Entreprise();
        $entreprise
            ->setNom($nom)
            ->setDescription($description)
        ;

        $service = $this->randomService($manager);
        $entreprise->addService($service);

        return $entreprise;
    }

    private function createOffre(
        string $nom,
        string $description,
        float $salaire,
        Entreprise $entreprise,
        array $tags
    ): Offre {
        $offre = new Offre();

        $offre
            ->setNom($nom)
            ->setDescription($description)
            ->setSalaire($salaire)
            ->setEntreprise($entreprise)
        ;

        foreach ($tags as $tag) {
            $offre->addTag($tag);
        }

        return $offre;
    }

    private function randomService(ObjectManager $manager): Service
    {        
        return $manager
            ->getRepository(Service::class)
            ->findByNom(self::SERVICES[array_rand(self::SERVICES)])[0]
        ;
    }

    private function randomEntreprise(ObjectManager $manager): Entreprise
    {
        $entrepriseRepository = $manager->getRepository(Entreprise::class);
        $entreprises = $entrepriseRepository->findAll();

        return $entreprises[array_rand($entreprises)];
    }

    private function randomTags(ObjectManager $manager): array
    {
        $tags = [];
        
        for ($i = 0; $i < 3; $i++) {
            $tags[] = $manager
                ->getRepository(Tag::class)
                ->findByNom(
                    self::TAGS[array_rand(self::TAGS)]
                )[0]
            ;
        }
        
        return $tags;
    }
}
