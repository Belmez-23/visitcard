<?php

namespace App\Controller;

use App\Service\BaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BaseController extends AbstractController
{
    private $twig;
    private $service;

    public function __construct(Environment $twig, BaseService $service)
    {
        $this->twig = $twig;
        $this->service = $service;
    }

    public function index(Request $request): Response
    {
        $feedbackForm = $this->createFormBuilder()
            ->add('name', TextType::class, ['required' => false])
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $feedbackForm->handleRequest($request);

        if ($feedbackForm->isSubmitted() && $feedbackForm->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $feedback = $feedbackForm->getData();
            // TODO: отправка письма на почту и плашка Письмо (не) отправлено
        }

        return new Response($this->twig->render('base.html.twig', [
            'chapters' => $this->service->getResume(),
            'feedback' => $feedbackForm->createView(),
        ]));
    }

    public function textGenerator(Request $request): Response
    {
        return new Response($this->twig->render('text.html.twig', [
            'customname' => $request->get('customname'),
            'ukus' => $request->get('ukus'),
        ]));
    }
}
