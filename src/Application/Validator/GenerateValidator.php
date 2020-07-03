<?php

declare(strict_types=1);

namespace App\Application\Validator;

use Respect\Validation\Validator as v;

class GenerateValidator implements ValidatorInterface
{
    /**
     * @param $input
     * @return mixed
     */
    public  function validate($input)
    {
        $validate = [];

        $validate['html'] = v::stringType()->validate($input['html']);

        if (isset($input['paper'])) {
            $validate['paper'] = v::arrayType()->validate($input['paper'])
            && isset($input['paper']['size'], $input['paper']['orientation']);
        }

        foreach ($validate as $key => $value) {
            if(!$value) {
                throw new ValidationException('validation fails for ' . $key);
            }
        }
    }
}