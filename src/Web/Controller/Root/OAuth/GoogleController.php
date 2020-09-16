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

namespace Depense\Web\Controller\Root\OAuth;

use Depense\Module\User\Enum\OAuthProvider;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/oauth/google", name="root_oauth_google_")
 */
class GoogleController
{
    /**
     * @param ClientRegistry $clientRegistry
     *
     * @return Response
     *
     * @Route("/connect", name="connect")
     */
    public function connect(ClientRegistry $clientRegistry): Response
    {
        /** @var GoogleClient $client */
        $client = $clientRegistry->getClient(OAuthProvider::GOOGLE);

        return $client->redirect();
    }

    /**
     * @return Response
     *
     * @Route("/check", name="check")
     */
    public function check(): Response
    {
        throw new LogicException('This method can be blank - it will be intercepted by the authenticator.');
    }
}
