<?php

namespace Reporting\Format;

use Reporting\Report;

interface DeserializeInterface
{
    public function deserialize(string $input): Report;
}
