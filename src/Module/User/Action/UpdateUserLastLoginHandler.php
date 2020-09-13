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

use Depense\Module\Core\Action\HandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class UpdateUserLastLoginHandler implements HandlerInterface
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateUserLastLogin $message): void
    {
        $user = $message->getUser();

        $user->setLastLogin(new DateTime());

        $this->entityManager->flush();
    }
}
