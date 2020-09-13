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

namespace Depense\Module\Core\DependencyInjection\Compiler;

use Depense\Module\Core\Action\ActionRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ActionRegistryPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition(ActionRegistry::class);

        foreach ($container->findTaggedServiceIds('depense.core.action_handler') as $class => $attrs) {
            $registry->addMethodCall('addHandler', [new Reference($class)]);
        }

        foreach ($container->findTaggedServiceIds('depense.core.action') as $class => $attrs) {
            $registry->addMethodCall('addAction', [$class]);
        }
    }
}
