<?php

namespace Office;

class Employee
{
    protected $firstName;
    protected $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function work()
    {
        return "Je suis $this->firstName et je bosse !";
    }
}
