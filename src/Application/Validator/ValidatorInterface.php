<?php

declare(strict_types=1);

namespace App\Application\Validator;

interface ValidatorInterface
{
    /**
     * @param mixed $input
     * @return mixed
     */
    public function validate($input);
}