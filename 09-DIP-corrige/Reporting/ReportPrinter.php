<?php

namespace Reporting;

use Reporting\Format\JsonFormatter;
use Reporting\Format\FormatterInterface;

class ReportPrinter
{
    protected $formatter;
    protected $report;

    /**
     * Injectez moi mes dépendances ! C'est vous qui choisissez le $report que je vais utiliser
     * et c'est aussi vous qui choisissez le $formatter que je vais utiliser !
     * 
     * Je dépend d'abstractions (hmm, sauf pour le Report à vrai dire :D) !
     *
     * @param Report $report
     * @param FormatterInterface $formatter
     */
    public function __construct(Report $report, FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
        $this->report = $report;
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
