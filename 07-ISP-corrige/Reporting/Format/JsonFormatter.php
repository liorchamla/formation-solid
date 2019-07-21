<?php

namespace Reporting\Format;

/**
 * Cette classe permet de formater un Report au format JSON, elle ne devrait changer que si le formattage JSON
 * doit lui-même changer
 */
class JsonFormatter implements FormatterInterface, DeserializeInterface
{
    public function format(\Reporting\Report $report): string
    {
        // La fameuse méthode publique getContents() qui nous donne les infos qu'on veut 
        // sous la forme d'un tableau associatif (avec les clés title et date)
        $content = $report->getContents();

        // On encode en JSON le tableau associatif envoyé
        return json_encode($content);
    }

    public function deserialize(string $input): \Reporting\Report
    {
        $contents = json_decode($input);
        $title = $contents->title;
        $date = $contents->date;
        // On retourne un rapport vide juste pour satisfaire le type hinting
        return new \Reporting\Report($date, $title);
    }
}
