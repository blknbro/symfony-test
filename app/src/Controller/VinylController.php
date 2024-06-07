<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Service\MixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VinylController extends AbstractController
{

    public function __construct(
        private MixRepository $mixRepository,
        private bool $isDebug
    )
    {

    }

    #[Route('/vinyl',name: 'app_homepage_vinyl')]
    public function homepage():Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        return $this->render('vinyl/homepage.html.twig',[
            'title' => 'PB & Jams',
            'tracks' => $tracks
        ]);

    }

    #[Route('/browse/{slug}',name: 'app_browse')]
    public function browse(EntityManagerInterface $entityManager, string $slug = null): Response
    {


        $genre = $slug ? u(str_replace('-',' ',$slug))->title(true) : null;


        $mixRepository = $entityManager->getRepository(VinylMix::class);
        $mixes = $mixRepository->findAll();
        dd($mixes);




        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);

    }




}