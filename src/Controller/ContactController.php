<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
   /**
    * @Route("/contact", name="contact")
    * @throws TransportExceptionInterface
    */
    public function index(BannerRepository $banner, MailerInterface $mailer, Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           $contact = $form->getData();
           $email = (new Email())
              ->from(new Address($contact['email'], $contact['username']))
              ->to(new Address('contact@ousseine.fr'))
              ->subject($contact['subject'])
              ->html($contact['content']);

           # dump($email); die();
           $mailer->send($email);

           $this->addFlash('success', 'Votre message à bien été envoyé');
           return $this->redirectToRoute('contact', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('main/contact/index.html.twig', [
            'banner' => $banner->findOneBy(['name' => 'contact']),
            'form'   => $form->createView()
        ]);
    }
}
