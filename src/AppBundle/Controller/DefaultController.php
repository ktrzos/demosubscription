<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\CardType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default application controller.
 *
 * @package AppBundle\Controller
 * @author  Krzysztof Trzos
 */
class DefaultController extends Controller
{
    /**
     * Homepage action.
     *
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('default/homepage.html.twig');
    }

    /**
     * Homepage action.
     *
     * @param Request $request
     * @return Response
     */
    public function formAction(Request $request): Response
    {
        $form = $this->createForm(CardType::class);
        $form->handleRequest($request);

        # check if form is submitted
        if($form->isSubmitted() && $form->isValid()) {
            $this->sendEmail();
            $this->addFlash('success', 'Form has been sent!');

            return $this->redirectToRoute('form');
        }

        # return rendered view
        return $this->render('default/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Homepage action.
     *
     * @return Response
     */
    public function listAction(): Response
    {
        return $this->render('default/list.html.twig');
    }

    /**
     * @return bool
     */
    private function sendEmail(): bool
    {
        return true;
    }
}
