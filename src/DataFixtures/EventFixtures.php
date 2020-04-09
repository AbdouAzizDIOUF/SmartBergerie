<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;

class EventFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $evens1 = new Event();
        $evens1->setTitle('KORITE');
        $evens1->setContenu('Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku. 
Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku.');
        $evens2 = new Event();
        $evens2->setTitle('GAMOU');
        $evens2->setContenu('Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku. 
Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku.');
        $evens3 = new Event();
        $evens3->setTitle('MAGGAL');
        $evens3->setContenu('Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku. 
Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku.');

        $evens4 = new Event();
        $evens4->setTitle('APPEL');
        $evens4->setContenu('Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku. 
Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue. Un texte n\'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku.');

        $manager->persist($evens1);
        $manager->persist($evens2);
        $manager->persist($evens3);
        $manager->persist($evens4);
        $manager->flush();
    }
}
