<?php

declare(strict_types=1);

namespace App\Api\Request\Security;

use App\Api\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank
     *
     * @Assert\Email
     */
    public string $email = '';

    /**
     * @Assert\NotBlank
     */
    public string $password = '';
}
