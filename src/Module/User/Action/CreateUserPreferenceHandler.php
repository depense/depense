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
use Depense\Module\User\Factory\UserPreferenceFactory;
use Depense\Module\User\Repository\UserPreferenceRepository;

class CreateUserPreferenceHandler implements HandlerInterface
{
    private UserPreferenceRepository $preferenceRepository;
    private UserPreferenceFactory $factory;

    public function __construct(UserPreferenceFactory $factory, UserPreferenceRepository $preferenceRepository)
    {
        $this->preferenceRepository = $preferenceRepository;
        $this->factory = $factory;
    }

    public function __invoke(CreateUserPreference $message): void
    {
        $preference = $this->factory->createForUser(
            $message->getUser()
        );

        $this->preferenceRepository->add($preference);
    }
}
