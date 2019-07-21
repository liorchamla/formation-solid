<?php

namespace Reporting;

use Reporting\Format\JsonFormatter;
use Reporting\Format\HtmlFormatter;

class ReportExtractor
{
    /**
     * Le tableau qui contiendra les différents formatters
     *
     * @var array
     */
    protected $formatters = [];

    /**
     * Permet d'ajouter un formateur HTML au tableau des formatters
     *
     * @param HtmlFormatter $htmlFormatter
     *
     * @return void
     */
    public function addHtmlFormatter(HtmlFormatter $htmlFormatter): void
    {
        $this->formatters[] = $htmlFormatter;
    }

    /**
     * Permet d'ajouter un formateur JSON au tableau
     *
     * @param JsonFormatter $jsonFormatter
     *
     * @return void
     */
    public function addJsonFormatter(JsonFormatter $jsonFormatter): void
    {
        $this->formatters[] = $jsonFormatter;
    }

    /**
     * Doit afficher l'ensemble des formats possibles pour un rapport en se servant
     * des formatters ajoutés dans le tableau
     *
     * @param Report $report
     *
     * @return void
     */
    public function process(Report $report): void
    {
        // Pour chaque formatter dans le tableau
        foreach ($this->formatters as $formatter) {
            // Si le formatter est un HtmlFormatter
            if ($formatter instanceof HtmlFormatter) {
                // On appelle la méthode formatToHtml
                echo $formatter->formatToHtml($report);
            }
            // Sinon, si c'est un JsonFormatter
            else if ($formatter instanceof JsonFormatter) {
                // On appelle la méthode formatToJson
                echo $formatter->formatToJSON($report);
            }
            echo "<hr/>";
        }

        // Voilà une méthode que je vais devoir modifier à chaque fois qu'on voudra créer un nouveau type
        // de format à ce projet ... pas très Open/Closed ;-)
    }
}
