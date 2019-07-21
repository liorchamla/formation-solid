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
 * CORRIGE DE L'EXERCICE
 * ---------------------
 * Ce corrigé n'engage que l'auteur de ces lignes, évidemment vous avez peut-être décidé d'une stratégie
 * tout à fait différente avec votre prof, et c'est ce qui est beau dans le développement : Il n'y a jamais
 * qu'une seule et même solution à un problème ! :-)
 * 
 * Questions à discuter avec votre prof :
 * --------------------------------------
 * Question 1 : D'après vous, pour quelles raisons la classe pourrait changer ?
 * Dans le code de base, la classe pourrait changer :
 * 1) Parce que les données du rapport ont évolué 
 * 2) Parce que le formattage HTML doit évoluer
 * 3) Parce que le formattage JSON doit évoluer
 * 
 * Question 2 : Combien de classes devrait il y avoir pour que chacune n'ait qu'une seule responsabilité ?
 * Si on veut suivre le SRP, on pourrait imaginer au minimum 3 classes :
 * - Une qui porte les données du Rapport, qui représente le Rapport (et qui ne changerait que si les données 
 * du rapport doivent changer)
 * - Une qui est chargée du formattage HTML (et qui ne changerait que si le formattage HTML doit changer)
 * - Une qui est chargée du formattage JSON (et qui ne changerait que si le formattage JSON doit évoluer)
 * 
 * Question 3 : Devrait-on envisager de séparer les classes entre différents Namespaces (donc dossiers) ?
 * A mon sens, il semble pertinent de préciser un nouveau namespace pour les classes de 
 * formattage ! Mais ce n'est absolument pas obligatoire :-)
 * 
 * NOUVELLE STRUCTURE :
 * --------------------
 * - On a donc un nouveau dossier Reporting/Format qui contiendra les classes  de formatage
 * - On a deux classes Reporting\Format\JsonFormatter et Reporting\Format\HtmlFormatter
 * - Et on a bien sur encore notre classe Reporting\Report qui ne sert plus qu'à porter les données d'un rapport
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

// Création du Report
$report = new Reporting\Report('2016-04-21', 'Titre de mon rapport');

// Création des formatteurs
$jsonFormatter = new \Reporting\Format\JsonFormatter();
$htmlFormatter = new \Reporting\Format\HtmlFormatter();

// Même comportement que dans l'énoncé
echo $htmlFormatter->formatToHtml($report);
echo '<hr>';
echo $jsonFormatter->formatToJSON($report);
