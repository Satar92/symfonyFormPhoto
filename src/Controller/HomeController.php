<?php

namespace App\Controller;

use App\Service\AppHelpers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    // #[Route('/', name: 'app_home')]
    public function index(AppHelpers $app): Response
    {
        $app->installBDD();
        return $this->render('home/index.html.twig');
    }
}
