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
        $mix = new VinylMix();
        $mix
            ->setTitle('Mix 7')
            ->setDescription('Mix 7 Description')
            ->setGenre('pop')
            ->setTrackCount(rand(5, 20))
            ->setVotes(rand(-50, 50))
        ;

        $em->persist($mix);
        $em->flush();

        return new Response(sprintf(
            'New mix #%d with %d tracks created',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }
}
