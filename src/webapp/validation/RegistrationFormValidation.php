<?php

namespace tdt4237\webapp\validation;

use tdt4237\webapp\models\User;

class RegistrationFormValidation
{
    const MIN_USER_LENGTH = 3;
    
    private $validationErrors = [];
    
    public function __construct($username, $password, $first_name, $last_name, $phone, $company)
    {
        return $this->validate($username, $password, $first_name, $last_name, $phone, $company);
    }
    
    public function isGoodToGo()
    {
        return empty($this->validationErrors);
    }
    
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    private function validate($username, $password, $first_name, $last_name, $phone, $company)
    {
        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,50}$/', $password)) {
            $this->validationErrors[] = 'Password must be between 8 and 50 characters, and contain at least one character and one number';
        }

        if(empty($first_name)) {
            $this->validationErrors[] = "Please write in your first name";
        }

         if(empty($last_name)) {
            $this->validationErrors[] = "Please write in your last name";
        }

        if(empty($phone)) {
            $this->validationErrors[] = "Please write in your post code";
        }

        if (strlen($phone) != "8") {
            $this->validationErrors[] = "Phone number must be exactly eight digits";
        }

        if(strlen($company) > 0 && (!preg_match('/[^0-9]/',$company)))
        {
            $this->validationErrors[] = 'Company can only contain letters';
        }

        if (preg_match('/^[A-Za-z0-9_]+$/', $username) === 0) {
            $this->validationErrors[] = 'Username can only contain letters and numbers';
        }
    }

}
