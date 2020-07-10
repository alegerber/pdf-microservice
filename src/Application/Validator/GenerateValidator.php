<?php

declare(strict_types=1);

namespace App\Application\Validator;

use Respect\Validation\Validator as v;

class GenerateValidator implements ValidatorInterface
{
    /**
     * @param mixed $input
     * @return mixed
     */
    public  function validate($input)
    {
        $validate = [];

        $validate['html'] = isset($input['html']) && v::stringType()->validate($input['html']);

        if (isset($input['paper'])) {
            $validate['paper'] = isset($input['paper']['size'], $input['paper']['orientation'])
            && v::arrayType()->validate($input['paper']);
        }

        if (isset($input['options'])) {
            $validate['options'] = v::arrayType()->validate($input['options']);
        }

        if (isset($input['stream'])) {
            $validate['stream'] = v::boolType()->validate($input['stream']);
        }

        foreach ($validate as $key => $value) {
            if(!$value) {
                throw new ValidationException('validation fails for \'' . $key . '\'');
            }
        }
    }
}