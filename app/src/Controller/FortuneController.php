<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\FortuneCookieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FortuneController extends BaseController
{


    #[Route('/fortune', name: 'app_fortune_home',)]
    #[IsGranted("IS_AUTHENTICATED_REMEMBERED")]
    public function index(CategoryRepository $repository, Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
//        $entityManager->getFilters()
//            ->enable('fortuneCookie_discontinued')
//            ->setParameter('discontinued', false);

        $searchTerm = $request->query->get('q');

        $logger->info('{user} is voting',[
            'user' => $this->getUser()->getEmail()
        ]);


        if ($searchTerm) {
            $categories = $repository->search($searchTerm);
        } else {
            $categories = $repository->findAllOrder();
        }


        return $this->render('fortune/homepage.html.twig', [
            'categories' => $categories,
        ]);

    }

    #[Route('/fortune/category/{id}', name: 'app_category_show')]
    public function showCategory(int $id, CategoryRepository $categoryRepository, FortuneCookieRepository $cookieRepository): Response
    {
        $category = $categoryRepository->findWithFortunesJoin($id);
        if (!$category) {
            throw $this->createNotFoundException("category not found");
        }

        $stats = $cookieRepository->countNumberPrintedForCategory($category);

        return $this->render('fortune/showCategory.html.twig', [
            'category' => $category,
            'fortunesPrinted' => $stats->fortunesPrinted,
            'fortunesAverage' => $stats->fortunesAverage,
            'categoryName' => $stats->categoryName,
        ]);
    }

    #[Route(path: '/fortune/info')]
    public function fortuneInfo()
    {
         $this->denyAccessUnlessGranted('ROLE_COOKIE_ADMIN');

        return new Response('Pretend something is here.');
    }


}