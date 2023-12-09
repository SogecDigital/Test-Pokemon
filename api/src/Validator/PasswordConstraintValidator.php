<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PasswordConstraintValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PasswordConstraint) {
            throw new UnexpectedTypeException($constraint, PasswordConstraint::class);
        }

       if (!is_string($value)) {
           throw new UnexpectedTypeException($value, 'string');
       }

       if (strlen($value) < 8) {
           $this->context->buildViolation('The password must contain at least 8 characters.')
               ->addViolation();
       }

        if(preg_match('/[A-Z]/', $value) === 0) {
            $this->context->buildViolation('The password must contain at least one upper-case letter.')
                ->addViolation();
        }

        if(preg_match('/[a-z]/', $value) === 0) {
            $this->context->buildViolation('The password must contain at least one lower-case letter.')
                ->addViolation();
        }

        if (strpbrk($value, ',;:?./@#"\'{}[]-_()$*%=+') === false) {
            $this->context->buildViolation('The password must contain at least one special character.')
                ->addViolation();
        }
    }
}
