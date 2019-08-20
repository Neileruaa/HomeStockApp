<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Entity\Invitation;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invitation")
 * @IsGranted("ROLE_USER")
 */
class InvitationController extends AbstractController
{
    /**
     * @Route("/{id}/new")
     * @Security("is_granted('headFamily', famille)")
     */
    public function new(Request $request, Famille $famille, UserRepository $userRepository)
    {
        $form = $this->createFormBuilder()
            ->add('receiver', EmailType::class)
            ->add('save', SubmitType::class, ['label' => 'Inviter'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $invitation = new Invitation();
            $invitation->setAuthor($this->getUser());
            $invitation->setActive(true);
            $invitation->setCreatedAt(new \DateTime());
            $invitation->setReceiver($userRepository->findOneBy(['email' => $form->getData()['receiver']]));

            $em->persist($invitation);
            $em->flush();

            return $this->redirectToRoute('app_famille_show');
        }

        return $this->render('invitation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
