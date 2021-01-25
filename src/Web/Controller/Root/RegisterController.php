<?php
/*
 * This file is part of the Depense.Net package.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Depense\Web\Controller\Root;

use Depense\Module\User\Action\RegisterUser;
use Depense\Module\User\Model\User;
use Depense\Web\Form\RegisterType;
use Depense\Web\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Depense\Web\Controller\AbstractController;

class RegisterController extends AbstractController
{
    /**
     * @param Request                    $request
     * @param UserAuthenticatorInterface $authenticator
     * @param LoginFormAuthenticator     $formAuthenticator
     *
     * @return Response
     *
     * @Route("/register", name="root_register")
     */
    public function register(Request $request, UserAuthenticatorInterface $authenticator, LoginFormAuthenticator $formAuthenticator): Response
    {
        $form = $this->createForm(RegisterType::class, $user = new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->perform(new RegisterUser($user));

            return $authenticator->authenticateUser($user, $formAuthenticator, $request);
        }

        return $this->render('root/register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
