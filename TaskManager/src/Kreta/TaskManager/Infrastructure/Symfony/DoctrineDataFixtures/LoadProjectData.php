<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kreta\TaskManager\Infrastructure\Symfony\DoctrineDataFixtures;

use Kreta\TaskManager\Infrastructure\Persistence\Doctrine\DataFixtures\LoadProjectData as BaseLoadProjectData;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadProjectData extends BaseLoadProjectData implements ContainerAwareInterface
{
    public function setContainer(ContainerInterface $container = null)
    {
        $this->commandBus = $container->get('kreta.task_manager.command_bus');
        $this->queryBus = $container->get('kreta.task_manager.query_bus');
    }
}
