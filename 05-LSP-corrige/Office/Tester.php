<?php

namespace Office;

class Tester extends Employee
{
    public function work()
    {
        return "Je suis $this->firstName et je teste des trucs !";
    }
}
