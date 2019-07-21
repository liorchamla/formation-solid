<?php

/**
 * COURS :
 * -------
 * Cet exercice traite du S de SOLID (Single Responsibility Principle - Principe de Responsabilité Unique)
 * Ce principe postule qu'une classe ne devrait avoir qu'une seule responsabilité mais pas plusieurs.
 * 
 * On estime donc qu'on peut avoir une classe dont le rôle est simplement d'être porteuse de données, une autre
 * dont le rôle est de traiter les données d'une certaine façon, une autre de les traiter d'une autre façon, etc.
 * 
 * Dans l'idéal, quand on créé une classe, ou qu'on lit celle de quelqu'un d'autre, on devrait toujours
 * se poser la question suivante : `Est-ce que j'ai plus d'une seule raison de modifier cette classe à l'avenir ?!`
 * 
 * Si la réponse est `Oui`, alors on ne respecte pas le Single Responsibility Principle.
 * 
 * Gardez à l'esprit que c'est un PRINCIPE, ce qui veut dire qu'il ne faut pas non plus l'appliquer ABSOLUMENT
 * et SYSTEMATIQUEMENT. On vous paye pour réfléchir et décider, si c'était juste pour appliquer bêtement, on
 * emploierait des singes savants.
 * 
 * ENNONCE DE L'EXERCICE :
 * -----------------------
 * Dans votre entreprise, quelqu'un a codé un système de Reporting qui permet de créer des rapports d'activité.
 * 
 * Un rapport d'activité, pour l'instant ce n'est qu'un titre et une date d'édition, le développeur
 * a donc créé une classe Reporting\Report qui contient les propriétés $date et $title
 * 
 * On a besoin de pouvoir extraire ce rapport sous deux formes :
 * - HTML (afin de l'afficher dans le navigateur)
 * - JSON (si jamais on veut l'exporter vers du Javascript ou autre)
 * 
 * Le développeur a donc ajouté deux méthodes à sa classe : formatToHTML() et formatToJSON(), pas bête, mais
 * cela signifie donc que sa classe a bien des raisons d'être modifiée dans le futur.
 * 
 * Questions à discuter avec votre prof :
 * --------------------------------------
 * Question 1 : D'après vous, pour quelles raisons la classe pourrait changer ?
 * Question 2 : Combien de classes devrait il y avoir pour que chacune n'ait qu'une seule responsabilité ?
 * Question 3 : Devrait-on envisager de séparer les classes entre différents Namespaces (donc dossiers) ?
 * 
 * Faites les modifications nécessaires pour que ce projet soit S comme SOLID !
 */

/**
 * Mise en place de l'autoloading (Chargement automatique des classes)
 * Et oui, plus besoin de require_once de partout ! :-)
 */
spl_autoload_register(function ($className) {
    // Attention, avec ce principe, vos dossiers et noms de fichiers doivent
    // correspondre exactement aux Namespaces et aux noms de classes 
    $className = str_replace("\\", "/", $className);
    require_once($className . ".php");
});

$report = new Reporting\Report('2016-04-21', 'Titre de mon rapport');

echo $report->formatToHTML();
echo '<hr>';
echo $report->formatToJSON();
