<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BaseController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return new Response($this->twig->render('base.html.twig', [
            'chapters' => [
                ['header' => 'Кто я',
                    'text' => 'cccc'],
                ['header' => 'Что я могу',
                    'text' => 'ccccc'],
                ['header' => 'Мой опыт',
                    'text' => 'cccc'],
            ],
        ]));
    }
}
