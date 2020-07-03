<?php

declare(strict_types=1);

namespace App\Application\Validator;

interface ValidatorInterface
{
    /**
     * @param $input
     * @return mixed
     */
    public function validate($input);
}