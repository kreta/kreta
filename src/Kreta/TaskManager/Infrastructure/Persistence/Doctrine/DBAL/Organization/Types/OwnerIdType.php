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

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\DBAL\Organization\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;

class OwnerIdType extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        if ($value instanceof OwnerId) {
            return $value->id();
        }

        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) : OwnerId
    {
        return OwnerId::generate($value);
    }

    public function getName() : string
    {
        return 'owner_id';
    }
}
