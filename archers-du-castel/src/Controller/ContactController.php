<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {

            // Vérification CSRF
            $submittedToken = $request->request->get('_token');
            if (!$this->isCsrfTokenValid('contact_form', $submittedToken)) {
                $this->addFlash('error', "❌ Token CSRF invalide.");
                return $this->redirectToRoute('app_contact');
            }

            // Récupération et nettoyage des données
            $nom = htmlspecialchars($request->request->get('nom'));
            $email = htmlspecialchars($request->request->get('email'));
            $message = htmlspecialchars($request->request->get('message'));
            $consent = $request->request->get('consent');

            // Vérification du consentement RGPD
            if (!$consent) {
                $this->addFlash('error', "❌ Vous devez accepter l'utilisation de vos données.");
                return $this->redirectToRoute('app_contact');
            }

            // Validation de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addFlash('error', "❌ Email invalide.");
                return $this->redirectToRoute('app_contact');
            }

            // Création de l'email
            $senderAddress = (string) $this->getParameter('mailer_from');
            $mail = (new Email())
                ->from($senderAddress)
                ->replyTo($email)
                ->to('lionel.lebreton@sfr.fr') // ← Mets ici l’adresse de ton association
                ->subject("📩 Nouveau message de $nom (site web Archers du Castel)")
                ->text("Nom: $nom\nEmail: $email\n\nMessage:\n$message");

            try {
                $mailer->send($mail);
                $this->addFlash('success', "✅ Merci $nom, votre message a bien été envoyé !");
            } catch (\Exception $e) {
                $this->addFlash('error', "❌ Désolé, une erreur est survenue. Merci de réessayer.");
            }
        }

        return $this->render('contact/index.html.twig');
    }
}
