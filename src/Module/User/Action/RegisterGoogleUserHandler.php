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

namespace Depense\Module\User\Action;

use Depense\Module\Core\Action\ActionPerformer;
use Depense\Module\Core\Action\HandlerInterface;
use Depense\Module\User\Enum\OAuthProvider;
use Depense\Module\User\Manager\UserManagerInterface;
use Depense\Module\User\Model\User;
use Depense\Module\User\Model\UserInterface;
use Depense\Module\User\Model\UserOAuth;
use Depense\Module\User\Model\UserOAuthInterface;
use Depense\Module\User\Repository\UserOAuthRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessTokenInterface;

class RegisterGoogleUserHandler implements HandlerInterface
{
    protected ActionPerformer $actionPerformer;

    protected UserOAuthRepository $oauthRepository;

    protected UserManagerInterface $userManager;

    public function __construct(ActionPerformer $actionPerformer, UserOAuthRepository $oauthRepository, UserManagerInterface $userManager)
    {
        $this->actionPerformer = $actionPerformer;
        $this->oauthRepository = $oauthRepository;
        $this->userManager = $userManager;
    }

    public function __invoke(RegisterGoogleUser $message): UserInterface
    {
        $googleUser = $message->getGoogleUser();
        $accessToken = $message->getAccessToken();

        // Find oauth user record
        if (null !== $userOAuth = $this->oauthRepository->findOne(OAuthProvider::GOOGLE, $googleUser->getId())) {
            // If exists, update userOAuth tokens & returns the user object.
            $this->updateUserOAuth($userOAuth, $googleUser, $accessToken);

            return $userOAuth->getUser();
        }

        // If user with the given email does not exist
        if (null === $user = $this->userManager->findUserByEmail($googleUser->getEmail())) {
            // Create a new one
            $user = new User();
            $user->setEmail($googleUser->getEmail());
            $user->setFirstName($googleUser->getFirstName());
            $user->setLastName($googleUser->getLastName());
            // set random password to prevent issue with not nullable field & potential security hole
            $user->setPlainPassword(substr(sha1($accessToken->getToken()), 0, 10));

            $this->actionPerformer->perform(new RegisterUser($user));
        }

        $userOAuth = new UserOAuth();

        $this->updateUserOAuth($userOAuth, $googleUser, $accessToken);

        $user->addOAuthAccount($userOAuth);

        return $user;
    }

    protected function updateUserOAuth(UserOAuthInterface $userOAuth, GoogleUser $googleUser, AccessTokenInterface $accessToken): void
    {
        $userOAuth->setIdentifier($googleUser->getId());
        $userOAuth->setProvider(OAuthProvider::GOOGLE);
        $userOAuth->setAccessToken($accessToken->getToken());
        $userOAuth->setRefreshToken($accessToken->getRefreshToken());
    }
}
