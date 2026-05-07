<?php

namespace Infrastructure\Shared\Email;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

final readonly class EmailSender
{
    public function __construct(
        private MailerInterface $mailer
    ) {}

    public function sendTemplatedEmail(string $to, string $subject, string $template, array $context = []): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@vetocare.com', 'VetoCare'))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $this->mailer->send($email);
    }
}
