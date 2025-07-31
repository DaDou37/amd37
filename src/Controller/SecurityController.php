<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Handles user authentication-related actions such as login and logout.
 */
class SecurityController extends AbstractController
{
    /**
     * Displays the login form and handles authentication errors.
     *
     * This route is used to render the login page. It provides the last entered
     * username and any authentication error that occurred during the login attempt.
     *
     * @param AuthenticationUtils $authenticationUtils Provides access to the last authentication error and last username.
     *
     * @return Response The rendered login page with context data.
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Retrieve the authentication error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Get the last entered username
        $lastUsername = $authenticationUtils->getLastUsername();

        // Render the login page with the last username and any error
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * Handles user logout.
     *
     * This method can remain blank as it will be intercepted by the Symfony security firewall.
     * The actual logout logic is handled automatically according to your security configuration.
     *
     * @throws \LogicException Always thrown to indicate that this method is intentionally left blank.
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // This method is never executed; it is intercepted by the firewall.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
