<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
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

    #[Route('/mix/{id<\d+>}', name: 'app_mix_show')]
    public function show(VinylMixRepository $mxRepository, int $id): Response
    {
        $mix = $mxRepository->find($id);
        if ($mix === null) {
            throw $this->createNotFoundException(sprintf('Mix #%d not found', $id));
        }

        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }

    #[Route('/mix/new', name: 'app_mix_new')]
    public function new(EntityManagerInterface $em): Response
    {
        $genres = ['pop', 'rock'];

        for ($i = 1; $i <= 17; $i++) {
            $mix = new VinylMix();
            $mix
                ->setTitle("Mix {$i}")
                ->setDescription("Mix {$i} Description")
                ->setGenre($genres[array_rand($genres)])
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
