<?php

namespace App\Controller;

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

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/favicon.ico", name="favicon")
     */
    public function favicon()
    {
        return new Response(<<<EOF
<html>
    <body>
        <img src="https://www.computerhope.com/jargon/h/img.gif" />
    </body>
</html>
EOF
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request): Response
    {
        $feedbackForm = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Представьтесь, пожалуйста', 'required' => false])
            ->add('email', EmailType::class, ['label' => 'Ваша электронная почта для обратной связи'])
            ->add('message', TextareaType::class, ['label' => ' '])
            ->add('send', SubmitType::class)
            ->getForm();

        $feedbackForm->handleRequest($request);

        if ($feedbackForm->isSubmitted() && $feedbackForm->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $feedback = $feedbackForm->getData();
            // TODO: отправка письма на почту и плашка Письмо (не) отправлено
        }

        return new Response($this->twig->render('base.html.twig', [
            'chapters' => [
                ['header' => 'Кто я',
                    'text' => 'cccc'],
                ['header' => 'Что я могу',
                    'text' => 'ccccc'],
                ['header' => 'Мой опыт',
                    'text' => 'cccc'],
            ],
            'feedback' => $feedbackForm->createView(),
        ]));
    }
}
