<?php

namespace App\Controller;

use App\Repository\VinylMixRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VinylController extends AbstractController
{

    public function __construct(
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
    public function browse(VinylMixRepository $mixRepository, string $slug = null): Response
    {


        $genre = $slug ?: null;


        $mixes = $mixRepository->findAllOrderedByVotes($slug);


        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);

    }






}