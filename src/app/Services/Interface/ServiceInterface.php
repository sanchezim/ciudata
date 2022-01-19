<?php

namespace App\Services\Interface;

interface ServiceInterface
{
    public function validate(array $rules): ServiceInterface;
}
