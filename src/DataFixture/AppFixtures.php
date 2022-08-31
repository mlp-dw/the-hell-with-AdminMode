<?php
namespace App\DataFixture;

use App\Entity\Quizz;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// php bin/console doctrine:fixtures:load
class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('admin');
        $user->setEmail('ml@gmail.com');
        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
        
        $faker = Faker\Factory::create('fr_FR');
       
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Quizz();
            $product->setUser($user);
            $product->setCreatedAt($faker->dateTime);
            $product->setResult($faker->imageUrl());
            $manager->persist($product);
        }

        $manager->flush();
    }
}