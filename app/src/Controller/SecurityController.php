<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Totp\TotpAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use function Symfony\Component\String\u;

class SecurityController extends BaseController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig',
        [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(AuthenticationUtils $authenticationUtils): Response
    {
        throw new \Exception('logout() should never be reached.');
    }


    #[Route("/authentication/2fa/enable", name: "app_2fa_enable")]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function enable2fa(TotpAuthenticatorInterface $authenticator, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        if(!$user->isTotpAuthenticationEnabled()){
            $user->setTotpSecret($authenticator->generateSecret());

            $entityManager->flush();
        }

        return $this->render('security/enable2fa.html.twig');

    }


    #[Route('/authentication/2fa/qr-code',name: 'app_qr_code')]
    #[IsGranted("ROLE_USER")]
    public function displayGoogleAuthenticatorQrCode(TotpAuthenticatorInterface $totpAuthenticator)
    {
        $qrCodeContent = $totpAuthenticator->getQRContent($this->getUser());
        $result = Builder::create()
            ->data($qrCodeContent)
            ->build();

        return new Response($result->getString(), 200, ['Content-Type' => 'image/png']);

    }

}
