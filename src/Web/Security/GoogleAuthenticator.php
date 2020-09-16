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

namespace Depense\Web\Security;

use Depense\Module\Core\Action\ActionPerformer;
use Depense\Module\User\Action\RegisterGoogleUser;
use Depense\Module\User\Enum\OAuthProvider;
use Depense\Module\User\Model\UserInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use KnpU\OAuth2ClientBundle\Exception\InvalidStateException;
use KnpU\OAuth2ClientBundle\Exception\MissingAuthorizationCodeException;
use KnpU\OAuth2ClientBundle\Security\Exception\IdentityProviderAuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Exception\InvalidStateAuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Exception\NoAuthCodeAuthenticationException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GoogleAuthenticator extends AbstractAuthenticator
{
    use AuthenticationEventsTrait;

    public const OAUTH_CHECK_ROUTE = 'root_oauth_google_check';

    protected ClientRegistry $clientRegistry;

    protected ActionPerformer $actionPerformer;

    protected UrlGeneratorInterface $urlGenerator;

    public function __construct(ClientRegistry $clientRegistry, ActionPerformer $actionPerformer, UrlGeneratorInterface $urlGenerator)
    {
        $this->clientRegistry = $clientRegistry;
        $this->actionPerformer = $actionPerformer;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        return self::OAUTH_CHECK_ROUTE === $request->attributes->get('_route');
    }

    /**
     * @inheritDoc
     */
    public function authenticate(Request $request): PassportInterface
    {
        $google = $this->getGoogleClient();

        try {
            $accessToken = $google->getAccessToken();
        } catch (MissingAuthorizationCodeException $e) {
            throw new NoAuthCodeAuthenticationException();
        } catch (IdentityProviderException $e) {
            throw new IdentityProviderAuthenticationException($e);
        } catch (InvalidStateException $e) {
            throw new InvalidStateAuthenticationException($e);
        }

        $user = $this->actionPerformer->perform(
            new RegisterGoogleUser($google->fetchUserFromToken($accessToken), $accessToken)
        );

        if (!$user instanceof UserInterface) {
            throw new UnsupportedUserException();
        }

        return new SelfValidatingPassport($user, [
            new RememberMeBadge()
        ]);
    }

    /**
     * @return GoogleClient|OAuth2ClientInterface
     */
    private function getGoogleClient(): GoogleClient
    {
        if (!isset($this->googleClient)) {
            $this->googleClient = $this->clientRegistry->getClient(OAuthProvider::GOOGLE);
        }

        return $this->googleClient;
    }

    protected function successRedirectUrl(): string
    {
        return $this->urlGenerator->generate('app_page_overview');
    }

    protected function failureRedirectUrl(): string
    {
        return $this->urlGenerator->generate('root_security_login');
    }
}
