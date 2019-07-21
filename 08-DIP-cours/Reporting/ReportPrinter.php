<?php

namespace Reporting;

use Reporting\Format\JsonFormatter;

class ReportPrinter
{
    protected $formatter;
    protected $report;

    public function __construct()
    {
        $this->formatter = new JsonFormatter();
        $this->report = new Report("2019-01-01", "Rapport annuel de développement");
    }

    public function print(): void
    {
        echo $this->formatter->format($this->report);
    }

    public function dump(): void
    {
        var_dump(
            $this->formatter->format($this->report)
        );
    }
}
