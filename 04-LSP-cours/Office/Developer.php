<?php

namespace Office;

class Developer extends Employee
{
    public function work()
    {
        return "Je suis $this->firstName et je développe des trucs !";
    }
}
