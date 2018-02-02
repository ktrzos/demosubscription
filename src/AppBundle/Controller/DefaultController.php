<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscription;
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
        return $this->render('@App/homepage.html.twig');
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
            $manager = $this->getDoctrine()->getManager();

            /* @var $entity Subscription */
            $entity = $manager
                ->getRepository('AppBundle:Subscription')
                ->find(1);

            if($entity !== null) {
                $entity->setStatus(Subscription::STATUS_ACTIVE);
                $manager->persist($entity);
                $manager->flush();
                $entity->setStatus(Subscription::STATUS_NEW);
                $manager->persist($entity);
                $manager->flush();

                $this->sendEmail();
                $this->addFlash('success', 'Form has been sent!');
            }

            return $this->redirectToRoute('form');
        }

        # return rendered view
        return $this->render('@App/form.html.twig', [
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
        $subscriptions = $this->getDoctrine()
            ->getRepository('AppBundle:Subscription')
            ->findByUser(1);

        return $this->render('@App/list.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * @return bool
     */
    private function sendEmail(): bool
    {
        return true;
    }
}
