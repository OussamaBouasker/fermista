<?php
// src/Service/MailerService.php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendOrderConfirmationEmail($toEmail, $orderDetails)
    {
        $email = (new Email())
            ->from('no-reply@tonshop.com') // Utilise une adresse e-mail valide
            ->to($toEmail)
            ->subject('Confirmation de votre commande')
            ->html(
                "<h1>Merci pour votre commande !</h1>
                <p>Nous avons bien reçu votre commande et nous vous remercions pour votre achat.</p>
                <h2>Détails de votre commande:</h2>
                <ul>
                    $orderDetails
                </ul>
                <h3>Total: XXX €</h3>
                <p>Merci et à bientôt sur notre shop !</p>"
            );

        $this->mailer->send($email);
    }
}
