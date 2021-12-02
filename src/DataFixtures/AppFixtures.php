<?php

namespace App\DataFixtures;

use App\Entity\About;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
       $this->passwordHasher = $passwordHasher;
    }

   /**
    * @throws \Exception
    */
   public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // create about fixtures
        $about = new About();
        $about
           ->setTitle($faker->sentence)
           ->setContent($faker->realText(1000))
           ->setImageName('img-about.jpg')
           ->setUpdatedAt(new \DateTimeImmutable('- 3 months'));
        $manager->persist($about);

        // create admin
        $user = new User();
        $adminPlainPassword = 'adminamdin';
        $hashAdminPassword = $this->passwordHasher->hashPassword($user, $adminPlainPassword);
        $user
           ->setName('admin')
           ->setEmail('admin@ousseine.fr')
           ->setPassword($hashAdminPassword)
           ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        // create author
        $user = new User();
        $authorPlainPassword = 'author';
        $hashAuthorPassword = $this->passwordHasher->hashPassword($user, $authorPlainPassword);
        $user
           ->setName('author')
           ->setEmail('author@ousseine.fr')
           ->setPassword($hashAuthorPassword)
           ->setRoles(['ROLE_AUTHOR']);
        $manager->persist($user);

        // create cateogries
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
           $category = new Category();
           $category->setName($faker->words($faker->numberBetween(2, 3), true));
           $manager->persist($category);
           $categories[] = $category;
        }

        // create comments
        $comments = [];
        for ($i = 1; $i <= 50; $i++) {
           $comment = new Comment();
           $minDate = '-' . mt_rand(0, 100) . ' days';
           $comment
              ->setUsername($faker->userName)
              ->setEmail($faker->email)
              ->setContent($faker->sentences(3, true))
              ->setPublishedAt(new \DateTimeImmutable($minDate));
           $manager->persist($comment);
           $comments[] = $comment;
        }

        // create posts
        for ($i = 1; $i <= 100; $i++) {
           $post = new Post();
           $minDate = '-' . mt_rand(0, 100) . ' days';
           $post
              ->setTitle($faker->sentence)
              ->setSummary($faker->realText(300))
              ->setContent($faker->realText(4000))
              ->setImageName('img-post-defaut.jpg')
              ->setCreatedAt(new \DateTimeImmutable('- 100 days'))
              ->setPublishedAt(new \DateTimeImmutable($minDate))
              ->setUpdatedAt(new \DateTimeImmutable($minDate))
              ->setIsPublished($faker->numberBetween(0, 1))
              ->addCategory($categories[$faker->numberBetween(4, 8)])
              ->addComment($comments[$faker->numberBetween(3, 10)]);
           $manager->persist($post);
        }

        $manager->flush();
    }
}
