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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\MemberCollection;
use Kreta\TaskManager\Domain\Model\Organization\OwnerCollection;
use PhpSpec\ObjectBehavior;

class OwnerCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerCollection::class);
        $this->shouldHaveType(MemberCollection::class);
    }
}
