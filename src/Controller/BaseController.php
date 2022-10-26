<?php

namespace App\Controller;

use App\Service\BaseService;
use App\Service\CsvConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function balls(): Response
    {
        return new Response($this->twig->render('balls.html.twig'));
    }

    public function dressUpGame(): Response
    {
        return new Response($this->twig->render('dress-up.html.twig', [
            'options' => [
                'hair' => [
                    'hairfront1.png', 'hairfront2.png', 'hairfront3.png'
                ],
                'dress' => [
                    'dress1.png', 'dress2.png', 'dress3.png'
                ],
                'shoe' => [
                    'shoe1.png', 'shoe2.png', 'shoe3.png'
                ],
            ]
        ]));
    }

    public function liftStuff()
    {
        $converter = new CsvConverter();
        $data = $converter->get(__DIR__ . '/../Pseudoentity/lift.csv');
        $totalWeight = 0;
        array_walk($data, function ($item) use (&$totalWeight) {
            $totalWeight += $item['reps'] * $item['totalWeightLifted'];
        });

        $form = $this->createFormBuilder()
            ->add('item', TextType::class, ['required' => true])
            ->add('reps', TextType::class, ['required' => true])
            ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $row = [
                'id' => random_int(0, 99999999),
                'reps' => $data['reps'],
                'itemLabel' => $data['itemLabel'],
                'totalWeightLifted' => 1,
            ];
            $converter->add(__DIR__ . '/../Pseudoentity/lift.csv', $row);
        }

        return new Response($this->twig->render('lift/index.html.twig', [
            'form' => $form->createView(),
            'repLogs' => $data,
            'totalWeight' => $totalWeight,
        ]));
    }

    public function deleteRep($id)
    {
        $file = __DIR__ . '/../Pseudoentity/lift.csv';
        $converter = new CsvConverter();
        $data = $converter->get($file);
        foreach ($data as $key => $row) {
            if ($row['id'] == $id) {
                unset($data[$key]);
                $converter->set($file, $data);

                return new Response(null, 204);
            }
        }

        return new Response(null, 404);
    }
}
