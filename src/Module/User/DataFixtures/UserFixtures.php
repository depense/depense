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

namespace Depense\Module\User\DataFixtures;

use Depense\Module\Core\Action\ActionPerformer;
use Depense\Module\User\Action\RegisterUser;
use Depense\Module\User\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    protected ActionPerformer $actionPerformer;

    public function __construct(ActionPerformer $actionPerformer)
    {
        $this->actionPerformer = $actionPerformer;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstName('foo');
        $user->setLastName('bar');
        $user->setEmail('test@mail.com');
        $user->setPlainPassword('password');

        $this->actionPerformer->perform(new RegisterUser($user));

        $manager->flush();
    }
}
