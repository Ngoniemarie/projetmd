<?php

namespace App\DataFixtures;
use App\Entity\Announce;
use App\Entity\Comment;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);





        $faker = Factory::create("fr_FR");

        $slugger = new Slugify();
         for ($i = 0; $i < 8 ; $i++){
 
         $announce = new Announce();
         $announce->setTitle($faker->sentence(3, false));
         $announce->setSlug($slugger->slugify($announce->getTitle()));
         $announce->setIntroduction($faker->text(200));
         $announce->setDescription($faker->text(800));
         $announce->setPrice(mt_rand(30000,60000));
         $announce->setAddress($faker->address(3));
         $announce->setcoverImage("https://picsum.photos/1200/300?random=". mt_rand(1, 5000));
         $announce->setRooms(mt_rand(1,5));
         $announce->setIsAvailable(mt_rand(0,1));
         $announce->setCreatedAt($faker->dateTimeBetween('-3 month','now'));




         for($j = 0; $j < 3 ; $j++ ){
            $comment = new comment();
            $comment->setAuthor($faker->name());
            $comment->setEmail($faker->email());
            $comment->setContent($faker->text(150));
            $comment->setCreatedAt($faker->dateTimeBetween('-4 month','now'));
                     
    
            $manager ->persist($comment);
            $announce->addComment($comment); //permet à doctrine d'enregistrer dans la BD
        }


        for($k = 0; $k < mt_rand(0,7) ; $k++ ){
            $image = new image();
            $image->setUrlImage( "https://picsum.photos/200/400?random=". mt_rand(1, 5000));
           
            $image ->setDescription($faker->sentence());
    
            $manager ->persist($image);
            $announce->addImage($image); //permet à doctrine d'enregistrer dans la BD
        }

         $manager->persist($announce);//permet à doctrine d'enregistrer dans la bd
   
         }
        $manager->flush();
    }
}
