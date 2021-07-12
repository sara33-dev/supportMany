<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Room;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    /**
     * @Route("/data", name="data")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user1 = new User();
        $user1->setName('David');

        $user2 = new User();
        $user2->setName('Damien');

        $user3 = new User();
        $user3->setName('Fred');

        $entityManager->persist($user1);
        $entityManager->persist($user2);
        $entityManager->persist($user3);


        $tchat1 = new Room();
        $tchat1->setName('Pompignac');
        $tchat1->addOccupant($user1);
        $entityManager->persist($tchat1);

        $tchat2 = new Room();
        $tchat2->setName('Bordeaux');
        $tchat2->addOccupant($user2);
        $tchat2->addOccupant($user3);
        $entityManager->persist($tchat2);

        $message1 = new Message();
        $message1->setContent('Salut SARA, nouvelle sur Tinder ?');
        $message1->setSpeaker($user1);
        $message1->setTchat($tchat1);

        $message2 = new Message();
        $message2->setContent('Hello SARA, belle gosse !');
        $message2->setSpeaker($user2);
        $message2->setTchat($tchat2);

        $message3 = new Message();
        $message3->setContent('Hé, ça matche !!;)');
        $message3->setSpeaker($user3);
        $message3->setTchat($tchat2);

        $entityManager->persist($message1);
        $entityManager->persist($message2);
        $entityManager->persist($message3);

        $entityManager->flush();


        return $this->render('data/index.html.twig', [
            'controller_name' => 'DataController',
        ]);
    }
}
