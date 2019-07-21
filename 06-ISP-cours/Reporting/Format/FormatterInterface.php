<?php

namespace Reporting\Format;

use Reporting\Report;

interface FormatterInterface
{
    public function format(Report $report): string;
    public function deserialize(string $input): Report;
}
