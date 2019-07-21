<?php

use Reporting\Format\JsonFormatter;
use Reporting\ReportPrinter;

/**
 * 
 * PREALABLE AU COURS :
 * --------------------
 * Bien comprendre la notion d'interface, d'héritage et de classes abstraites
 * 
 * COURS :
 * -------
 * Cet exercice traite du D de SOLID (Dependency Inversion Principle - Principe d'Inversion de Dépendance) : relativement hardcore mais un des plus puissants principes du SOLID
 * 
 * Imaginez une classe Company qui a besoin d'une classe Developer : Par exemple la méthode 
 * $company->processWork(Developer $developer) doit appeler $developer->work(). On voit bien que Company a 
 * besoin de Developer. 
 * 
 * On dit que la classe Developer est une dépendance de Company (ou que Company dépend de Developer).
 * 
 * Et donc Developer se sent super puissant et se dit que sans lui, Company ne sert à rien !
 * 
 * Imaginez maintenant que la classe Company change et dise qu'en réalité ce n'est pas forcément de Developer qu'
 * elle a besoin, mais de toute classe qui implémenterait l'interface WorkerInterface. 
 * 
 * La méthode de Company devient $company->processWork(WorkerInterface $worker).
 * 
 * Si la classe Developer veut continuer de bosser avec la classe Company, il faudra absolument que 
 * la classe Developer implémente l'interface WorkerInterface.
 * 
 * C'est donc à la classe Developer de faire l'effort d'être compatible avec Company en implémentant l'interface
 * demandée. Alors ? Qui dépend de qui maintenant hein ? On fait moins la maline là !
 * 
 * Il y a eu inversion de dépendance ! La classe Developer ne devient qu'un "plugin" parmis d'autres dont peut
 * très bien se servir la classe Company désormais. 
 * 
 * Si tout ça vous semble peu clair, ce n'est pas grave, vous pouvez le résumer en une seule phrase de l'oncle Bob :
 * "On ne doit dépendre que d'abstractions (interfaces ou classes abstraites) et pas d'implémentations (classes concrètes)"
 * 
 * Le but global de ce principe est de découpler le plus possible les classes les unes des autres afin que
 * chaque pièce puisse être remplaçable facilement.
 * 
 * Et si ça peut vous rassurer, on a mis en oeuvre ce principe dès le deuxième cours sur le OCP (Open/Closed
 * Principle) grâce à l'interface FormatterInterface
 * 
 * Souvent ce principe se confond avec un autre principe :le Principe d'Injection de Dépendance qui 
 * n'est qu'un MOYEN de mettre en oeuvre le Principe d'Inversion de Dépendance ! Le moyen le plus simple et le
 * plus beau
 * 
 * ENONCE DE L'EXERCICE :
 * ----------------------
 * Notre collègue qui n'en rate pas une est bien embêté : il a créé une classe ReportPrinter qui possède
 * deux méthodes pour afficher un rapport au format Html :
 * - print() qui affiche le rapport avec un `echo`
 * - dump() qui affiche le rapport avec un `var_dump`
 * 
 * Le problème c'est que cette classe définie elle même le rapport et le formatter à utiliser. En voyant ça
 * vous vous dites que c'est débile parce que ce serait bien utile de pouvoir donner à cette classe le rapport
 * que vous voulez et aussi de pouvoir choisir le formatter à utiliser (pas forcément Html, n'importe lequel) 
 * 
 * Analysez cette classe ReportPrinter, c'est le moment où vous réfléchissez en commun sur les bêtises de notre
 * collègue :D
 * 
 * Questions à discuter avec votre prof :
 * --------------------------------------
 * Question 1 : La classe ReportPrinter a-t-elle des dépendances ? Lesquelles ?
 * Question 2 : La classe ReportPrinter dépend-elle d'abstractions ou de classes concrètes ?
 * Question 3 : Possède-t-on une abstraction pour au moins une de ces dépendances ? Laquelle ?
 * Question 4 : Le principe d'injection de dépendance (à ne pas confondre avec le principe d'inversion de 
 * dépendance qu'on étudie ici) nous permettrait-il d'être plus souple ?
 * Question 5 : Quelle est la meilleure façon d'implémenter l'injection de dépendance ?
 * Question 6 : Comment pourrait-on choisir à la demande quel formatter devrait être utilisé par le ReportPrinter ?
 * Question 6 bis : Comment pourrait-on choisir à la demande quel rapport devrait être utilisé par le 
 * ReportPrinter ?
 * 
 * Faites en sorte qu'on puisse facilement customiser le ReportPrinter en décidant par nous mêmes du formatter à
 * utiliser et du Report à formater :-)
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

// Pour l'instant y a aucun choix :
$reportPrinter = new ReportPrinter();

$reportPrinter->print();
$reportPrinter->dump();
