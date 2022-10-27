<?php

namespace App\Controller;

use App\Service\Lift;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class LiftController extends AbstractController
{
    private $twig;
    private $service;

    public function __construct(Environment $twig, Lift $service)
    {
        $this->twig = $twig;
        $this->service = $service;
    }


    public function index(Request $request)
    {
        $data = $this->service->getHistoryList();

        $form = $this->createFormBuilder()
            ->add('item', ChoiceType::class, ['required' => true, 'choices' => array_flip($this->service->getItemsList())])
            ->add('reps', TextType::class, ['required' => true])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->addToHistory($form->getData());
        }

        $data['form'] = $form->createView();

        return new Response($this->twig->render('lift/index.html.twig', $data));
    }

    public function deleteRep($id)
    {
        $deleteResult = $this->service->deleteFromHistory($id);

        return new Response(null, $deleteResult ? 204 : 404);
    }
}