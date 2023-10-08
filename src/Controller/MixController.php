<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    #[Route('/mix', name: 'app_mix')]
    public function index(): Response
    {
        return $this->render('mix/index.html.twig', [
            'controller_name' => 'MixController',
        ]);
    }

    #[Route('/mix/new', name: 'app_mix_new')]
    public function new(EntityManagerInterface $em): Response
    {
        for ($i = 1; $i <= 7; $i++) {
            $mix = new VinylMix();
            $mix
                ->setTitle("Mix {$i}")
                ->setDescription("Mix {$i} Description")
                ->setGenre('pop')
                ->setTrackCount(rand(5, 20))
                ->setVotes(rand(-50, 50))
            ;
            $em->persist($mix);
        }

        $em->flush();

        return new Response(sprintf(
            'New mix #%d with %d tracks created',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }
}
