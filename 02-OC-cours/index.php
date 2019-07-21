<?php

use Reporting\ReportExtractor;

/**
 * PREALABLE AU COURS :
 * --------------------
 * Bien comprendre la notion d'interface et d'abstraction : le fait qu'une instance d'une classe qui 
 * implémente une interface  peut être considérée comme "du type de cette interface". Notamment qu'une fonction
 * qui attend en paramètre un objet de type MonInterface, pourra recevoir en paramètre n'importe quel objet
 * dont la classe implémente l'interface MonInterface !
 * 
 * COURS :
 * -------
 * Cet exercice traite du O de SOLID (Open for extensions / Closed for modifications) : un des plus complexes
 * à comprendre.
 * 
 * L'idée générale est que le comportement d'une classe devrait pouvoir évoluer sans pour autant être 
 * modifiée (wtf ! Comment on peut faire ça ?!)
 * 
 * Il y a en réalité deux définitions de ce principe :
 * 1) La définition de Bertrand Meyer (en 1988) qui dit qu'une classe est ouverte si on peut l'étendre (en hériter)
 * ainsi, on peut créer une nouvelle classe qui sera la "même" en étendant ses fonctionnalités. Il dit aussi
 * qu'une classe est fermée dès qu'elle est utilisée par d'autres classes : on s'attend à ce qu'elle ne bouge plus
 * sous peine de tout péter ailleurs dans le code :x
 * 
 * 2) La définition de Robert C. Martin's (en 1996), la plus populaire et la plus utilisée depuis les années 1990
 * est différente. On dit qu'une classe est ouverte à l'extension et fermée à la modification si son comportement 
 * peut évoluer sans qu'on ait à la modifier.
 * 
 * Elle repose grosso modo sur le fait qu'une classe qui utilise une *ABSTRACTION* dans un de ses comportements
 * pourra facilement avoir un comportement différent en fonction de l' *IMPLEMENTATION* qu'on lui soumet.
 * 
 * C'est hardcore vous pensez ? Pas tant que ça. Voyez cet exercice et vous verrez ;-)
 * 
 * ENONCE DE L'EXERCICE :
 * -----------------------
 * 
 * Vous avez bien modifié le code de votre collègue afin qu'il réponde au Single Responsibility Principle ! 
 * Mais le voilà qui revient avec une nouvelle idée : un ReportExtractor à qui on donnerait différents formateurs
 * (Html, Json et pourquoi pas d'autres) afin qu'il imprime d'un seul coup le formatage HTML et le formatage JSON
 * et dans le futur encore d'autres formats.
 * 
 * Il a donc créé une classe ReportExtractor qui possède un tableau de formatters, et deux méthodes :
 * - addHtmlFormatter() qui permet d'ajouter au tableau un formatter Html
 * - addJsonFormatter() qui permet d'ajouter au tableau un formatter Json
 * 
 * Il suffira ensuite d'appeler la méthode process($report) et un foreach bouclera sur les différents formatters
 * pour afficher le rapport dans tous les formats possibles !
 * 
 * Magnifique idée mais la façon dont elle est implémentée pose problème ...
 * 
 * Questions à discuter avec votre prof :
 * --------------------------------------
 * Question 1 : Analysez bien la classe ReportExtractor. Si on devait créer un nouveau formatter qui ferait du
 * CSV, devrait-on modifier la classe ReportExtractor ? Que devrait-on faire pour chaque nouveau formatter ?
 * Question 2 : Vous semble-t-il logique que la classe HtmlFormatter et la classe JsonFormatter ont un nom
 * différent pour la méthode qui permet de formater un Report ?
 * Question 3 : Finalement, un formatter en JSON, un formatter en HTML, un formatter en CSV .. N'est-ce pas un 
 * peu la même chose ?
 * Question 4 : Y'aurait-il un moyen de faire en sorte que le ReportExtractor ne possède aucune référence
 * au type de formatter (Html, Json et même CSV ou autres dans le futur) pour fonctionner quand même ?
 * 
 * Votre mission est de modifier ce code de façon à ce qu'il soit possible, dans un futur proche, de créer de 
 * nouvelles classe de formatage (notamment un CsvFormatter par exemple) et de l'ajouter au ReportExtractor
 * sans avoir à modifier la classe ReportExtractor :-)
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

// Création de l'extracteur de rapport
$reportExtractor = new ReportExtractor();
// Ajout des deux formatters
$reportExtractor->addHtmlFormatter($htmlFormatter);
$reportExtractor->addJsonFormatter($jsonFormatter);

// Affichage des différents formats pour le rapport
$reportExtractor->process($report);
