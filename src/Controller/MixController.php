<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/mix/{slug}', name: 'app_mix_show')]
    public function show(VinylMix $mix): Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }

    #[Route('/mix/{slug}/vote', name: 'app_mix_vote', methods: [Request::METHOD_POST])]
    public function vote(VinylMix $mix, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->get('direction') === 'down') {
            $mix->downVote();
        } else {
            $mix->upVote();
        }

        $em->flush();
        $this->addFlash('success', 'Vote counted!');

        return $this->redirectToRoute('app_mix_show', ['slug' => $mix->getSlug()]);
    }
}
