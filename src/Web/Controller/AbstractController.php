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

namespace Depense\Web\Controller;

use Depense\Module\Core\Action\ActionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;

class AbstractController extends BaseAbstractController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'depense.core.action_performer' => 'Depense\Module\Core\Action\ActionPerformer'
        ]);
    }

    protected function perform(ActionInterface $action)
    {
        return $this->container->get('depense.core.action_performer')->perform($action);
    }
}
