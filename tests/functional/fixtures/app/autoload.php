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

use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(error_reporting() & ~E_USER_DEPRECATED);

$loader = require __DIR__ . '/../../../../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
