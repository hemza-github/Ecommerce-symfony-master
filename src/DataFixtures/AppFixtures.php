<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\Article;
use Doctrine\ORM\Query\Expr\Math;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setLogin('client')
                ->setPassword('password')
                ->setMail('client@client.com')
                ->setName('Doe')
                ->setFirstName('john')
                ->setAdress('123 street avenue')
                ->setPostalCode('12345')
                ->setCity('new-york')
                ->setPhone('0312345678');
        $encoded = $this->encoder->encodePassword($client, $client->getPassword());
        $client->setPassword($encoded);
        $manager->persist($client);


        $admin = new Admin();
        $admin->setUsername('admin')
            ->setPassword('password');
        $encoded = $this->encoder->encodePassword($admin, $admin->getPassword());
        $admin->setPassword($encoded);

        //dd($admin);
        $manager->persist($admin);


        for ($i = 1; $i < 10; $i++) {

            $u = $i - 1;
            $o = $i + 1;

            $article = new Article();
            $article->setTitle('Exemple article numero ' . $i)
                ->setIntroduction('Article numero ' . $i . ' est venu remplacer l\'article ' . $u . ' Avant d\'etre lui-meme remplacer par l\'article ' . $o)
                ->setDescription('Spicy jalapeno bacon ipsum dolor amet shank landjaeger kielbasa prosciutto, cow biltong fatback drumstick meatloaf ham short ribs burgdoggen corned beef bresaola venison. Short ribs rump chislic bacon frankfurter, hamburger chicken pork belly. Short ribs chuck swine rump. Leberkas t-bone chicken ground round capicola alcatra.   
                    ')
                ->setImage('https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/img(56).jpg')
                ->setPrice(rand(10, 1000));
            $manager->persist($article);
        }

        $manager->flush(); 
    }
}
