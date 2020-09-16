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

use Depense\Module\User\Manager\UserManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use function strlen;

class LoginFormAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    use AuthenticationEventsTrait;

    public const LOGIN_ROUTE = 'root_security_login';

    protected UserManagerInterface $userManager;

    protected UrlGeneratorInterface $urlGenerator;

    public function __construct(UserManagerInterface $userManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->userManager = $userManager;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse(
            $this->urlGenerator->generate(self::LOGIN_ROUTE)
        );
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * @inheritDoc
     */
    public function authenticate(Request $request): PassportInterface
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $csrfToken = $request->request->get('_token');

        if (empty($username) || empty($password)) {
            throw new CustomUserMessageAuthenticationException('Credentials should not be empty.');
        }

        if (strlen($username) > Security::MAX_USERNAME_LENGTH) {
            throw new BadCredentialsException('Invalid email.');
        }

        // Save the last username to the session
        // To prefilled it when retrying to login
        $request->getSession()
            ->set(Security::LAST_USERNAME, $username);

        if (null === $user = $this->userManager->findUserByEmail($username)) {
            throw new UsernameNotFoundException();
        }

        return new Passport($user, new PasswordCredentials($password), [
            new CsrfTokenBadge('authenticate', $csrfToken),
            new RememberMeBadge()
        ]);
    }

    protected function successRedirectUrl(): string
    {
        return $this->urlGenerator->generate('app_page_overview');
    }

    protected function failureRedirectUrl(): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
