<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        // Création de 10 Genres 
        for($i=0;$i<10;$i++) {
            $genre = new Genre();
            $genre -> setNom($faker->name());
            $this->addReference('genre_'.$i,$genre);
            $manager->persist($genre);
        }

        // Création de 20 Auteurs 
        for($i=0;$i<20;$i++) {
            $auteur = new Auteur();
            $auteur -> setNomPrenom($faker->name()." ".$faker->lastName())
                    -> setSexe($faker->randomElement(['male', 'female']))
                    -> setDateDeNaissance($faker->date($format = 'd/m/Y', $max = 'now'))
                    -> setNationalite($faker->country());
                    
            $this->addReference('auteur_'.$i,$auteur);
            $manager->persist($auteur);
        }

        // Création de 50 livres
        for($i=1 ; $i<=50 ; $i++){
            $livre= new Livre();
            for($j=1;$j<=$faker->numberBetween(1,2);$j++){
                $livre->addAuteur($this->getReference('auteur_'.$faker->numberBetween(0,19)));
            }
            for($j=1;$j<=$faker->numberBetween(1,2);$j++){
                $livre->addGenre($this->getReference('genre_'.$faker->numberBetween(0,9)));
            }
            $livre->setIsbn($faker->isbn13);
            $livre->setTitre($faker->realText(25));
            $livre->setDateDeParution($faker->date($format = 'd/m/Y', $max = 'now'));
            $livre->setNombrePages($faker->numberBetween($min = 10,$max=500));
            $livre->setNote($faker->numberBetween($min = 0,$max=20));
            
            $manager->persist($livre);
        }
        $manager->flush();
    }
}
