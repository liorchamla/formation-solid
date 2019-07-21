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
 * CORRIGE DE L'EXERCICE
 * ---------------------
 * Ce corrigé n'engage que l'auteur de ces lignes, évidemment vous avez peut-être décidé d'une stratégie
 * tout à fait différente avec votre prof, et c'est ce qui est beau dans le développement : Il n'y a jamais
 * qu'une seule et même solution à un problème ! :-)
 * 
 * Questions à discuter avec votre prof :
 * --------------------------------------
 * Question 1 : Analysez bien la classe ReportExtractor. Si on devait créer un nouveau formatter qui ferait du
 * CSV, devrait-on modifier la classe ReportExtractor ? Que devrait-on faire pour chaque nouveau formatter ?
 * => On devrait forcément ajouter une méthode addXXXFormatter() pour pouvoir enrichir le tableau des 
 * formatters
 * => On devrait également modifier la méthode process($report) pour ajouter un `else if()` qui prendrait en
 * compte le nouveau formatter
 * 
 * Question 2 : Vous semble-t-il logique que la classe HtmlFormatter et la classe JsonFormatter ont un nom
 * différent pour la méthode qui permet de formater un Report ?
 * => On peut estimer qu'avoir une méthode formatToJson() dans une classe qui s'appelle déjà JsonFormatter 
 * est un peu abusé : format() serait un nom suffisant, on comprend très bien que ce sera du JSON.
 * => Idem pour le HtmlFormatter : format() suffirait aussi. 
 * => Grosso modo, dans les deux cas, on veut formater, donc format() a du sens.
 * 
 * Question 3 : Finalement, un formatter en JSON, un formatter en HTML, un formatter en CSV .. N'est-ce pas un 
 * peu la même chose ?
 * => Complètement ! Ce ne sont que des classes qui ont une méthode formatToXXX(), et on pourrait même les 
 * uniformiser toutes en leur donnant un même nom de méthode (comme format() par exemple)
 * 
 * Question 4 : Y'aurait-il un moyen de faire en sorte que le ReportExtractor ne possède aucune référence
 * au type de formatter (Html, Json et même CSV ou autres dans le futur) pour fonctionner quand même ?
 * => Oui ! Si on créé une interface (par exemple FormatterInterface) qui impose une méthode format() aux classes
 * qui l'implémentent, on peut voir n'importe quelle instance d'une classe de formatage (HtmlFormatter,
 *  JsonFormatter etc) comme une instance de l'interface. Un peu comme si on ne traiter avec des instances d'une
 * seule et même classe !
 * => Du coup on peut avoir une seule méthode pour ajouter un formatter au tableau
 * => Du coup aussi on n'a plus à faire des if/elseif dans la boucle pour savoir si c'est tel ou tel formatter :D
 * 
 * NOUVELLE STRUCTURE :
 * --------------------
 * 1) On a ajouté une interface FormatterInterface avec une méthode format($report)
 * 2) Tous les formatters implémentent cette interface et ont donc désormais une méthode format($report) identique
 * 3) On a modifier profondément le ReportExtractor qui est maintenant ULTRA FLEXIBLE
 * 
 * Bonus : On vous montre grâce à la classe CsvFormatter qu'on peut enrichir la classe ReportExtractor sans toucher
 * une seule ligne grâce à notre nouveau code !
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
$reportExtractor->addFormatter($htmlFormatter);
$reportExtractor->addFormatter($jsonFormatter);

// Et hop, en CSV aussi :
$csvFormatter = new \Reporting\Format\CsvFormatter();
$reportExtractor->addFormatter($csvFormatter);

// Affichage des différents formats pour le rapport
$reportExtractor->process($report);
