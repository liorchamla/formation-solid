<?php

namespace Reporting\Format;

use Reporting\Report;

interface FormatterInterface
{
    public function format(Report $report): string;
}
