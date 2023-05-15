<?php

namespace App\Entity\Interface;

use App\Entity\User;

interface UserOwnedInterface
{
    public function getUser(): ?User;
}