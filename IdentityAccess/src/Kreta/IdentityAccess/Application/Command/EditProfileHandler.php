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

namespace Kreta\IdentityAccess\Application\Command;

use BenGorFile\File\Domain\Model\FileMimeType;
use BenGorFile\File\Domain\Model\FileName;
use BenGorFile\File\Domain\Model\Filesystem;
use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use Kreta\IdentityAccess\Domain\Model\User\FullName;
use Kreta\IdentityAccess\Domain\Model\User\User;
use Kreta\IdentityAccess\Domain\Model\User\UserEmailAlreadyExistsException;
use Kreta\IdentityAccess\Domain\Model\User\Username;
use Kreta\IdentityAccess\Domain\Model\User\UsernameAlreadyExistsException;
use Kreta\IdentityAccess\Domain\Model\User\UserRepository;

class EditProfileHandler
{
    private $repository;
    private $filesystem;

    public function __construct(UserRepository $repository, Filesystem $filesystem)
    {
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    public function __invoke(EditProfileCommand $command)
    {
        $id = new UserId($command->id());
        $email = new UserEmail($command->email());
        $username = Username::from($command->username());
        $fullName = new FullName($command->firstName(), $command->lastName());

        /** @var User $user */
        $user = $this->repository->userOfId($id);
        $this->checkUserExists($user);
        $this->checkEmailAndUsernameUniqueness($user, $username, $email);

        $user->editProfile($email, $username, $fullName);

        $uploadedImage = $command->uploadedImage();
        if ($uploadedImage) {
            $imageName = FileName::fromHash($command->imageName());
            $imageMimeType = new FileMimeType($command->imageMimeType());

            $this->filesystem->write($imageName, $uploadedImage);
            $user->uploadImage($imageName, $imageMimeType);
        }

        $this->repository->persist($user);
    }

    private function checkUserExists(User $user = null)
    {
        if (null === $user) {
            throw new UserDoesNotExistException();
        }
    }

    private function checkEmailAndUsernameUniqueness(User $user, Username $username, UserEmail $email)
    {
        $this->checkUsernameExists($user, $username);
        $this->checkEmailExists($user, $email);
    }

    private function checkUsernameExists(User $user, Username $username)
    {
        $anotherUser = $this->repository->userOfUsername($username);
        if (null !== $anotherUser && !$user->id()->equals($anotherUser->id())) {
            throw new UsernameAlreadyExistsException($username);
        }
    }

    private function checkEmailExists(User $user, UserEmail $email)
    {
        $anotherUser = $this->repository->userOfEmail($email);
        if (null !== $anotherUser && !$user->id()->equals($anotherUser->id())) {
            throw new UserEmailAlreadyExistsException($email);
        }
    }
}
