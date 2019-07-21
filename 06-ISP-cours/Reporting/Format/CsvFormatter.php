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

    public function deserialize(string $input): \Reporting\Report
    {
        throw new Exception("Impossible de désérialiser à partir du format CSV");
        // On retourne un rapport vide juste pour satisfaire le type hinting
        return new \Reporting\Report('', '');
    }
}
