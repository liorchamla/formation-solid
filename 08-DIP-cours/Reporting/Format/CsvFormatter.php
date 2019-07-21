<?php

namespace Reporting\Format;

class CsvFormatter implements FormatterInterface
{

    /**
     * Retourne une chaine au format CSV
     *
     * @param \Reporting\Report $report
     *
     * @return string
     */
    public function format(\Reporting\Report $report): string
    {
        // On colle les pièces du rapport en les séparant par un ";" :-)
        return implode(";", $report->getContents());
    }
}
