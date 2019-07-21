<?php

use Reporting\ReportPrinter;
use Reporting\Report;
use Reporting\Format\CsvFormatter;

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
 * CORRIGE DE L'EXERCICE
 * ---------------------
 * Ce corrigé n'engage que l'auteur de ces lignes, évidemment vous avez peut-être décidé d'une stratégie
 * tout à fait différente avec votre prof, et c'est ce qui est beau dans le développement : Il n'y a jamais
 * qu'une seule et même solution à un problème ! :-)
 * 
 * Questions à discuter avec votre prof :
 * --------------------------------------
 * Question 1 : La classe ReportPrinter a-t-elle des dépendances ? Lesquelles ?
 * => Clairement, elle a deux dépendances : elle a besoin d'une instance de Report et d'une instance de 
 * JsonFormatter. Elle les définie elle même, ce qui nous coupe toute possbilité de choix tant au niveau du
 * rapport qu'elle va afficher qu'au niveau du formatter qu'elle va utiliser
 * 
 * Question 2 : La classe ReportPrinter dépend-elle d'abstractions ou de classes concrètes ?
 * => Ici elle dépendait forcément de classes concrètes puisque c'est elle qui instanciait le Report ainsi que le
 * JsonFormatter
 * 
 * Question 3 : Possède-t-on une abstraction pour au moins une de ces dépendances ? Laquelle ?
 * => Nous n'avons pas d'abstraction pour Report, mais nous en avons bel et bien pour le JsonFormatter :
 * l'interface FormatterInterface !
 * 
 * Question 4 : Le principe d'inversion de dépendance nous permettrait-il d'être plus souple ?
 * => Evidemment ! Ca nous permettrait, AVANT de construire un ReportPrinter de créer nous même le rapport voulu et
 * le formatter voulu, et de passer ensuite ces objets au ReportPrinter
 * 
 * Question 5 : Quelle est la meilleure façon d'implémenter l'injection de dépendance ?
 * => Traditionnellement, on peut injecter des dépendances de plusieurs façon :
 * 1) Par le constructeur : on passe les dépendances lors de la construction de l'objet ReportPrinter
 * 2) Par des setters : on construit l'objet ReportPrinter, puis on appelle deux setters qui vont mettre en place
 * les instances
 * 3) Directement dans les méthodes print() et dump() en paramètre (pas pratique)
 * 
 * Question 6 : Comment pourrait-on choisir à la demande quel formatter devrait être utilisé par le ReportPrinter ?
 * => Il faudrait créer un formatter nous même HORS de la classe ReportPrinter et lui passer le formatter voulu
 * soit directement à la construction, soit par un setter après la construction
 * 
 * Question 6 bis : Comment pourrait-on choisir à la demande quel rapport devrait être utilisé par le 
 * ReportPrinter ?
 * => Même chose que pour le formatter, on créé l'instance de Report nous même HORS de la classe ReportPrinter
 * puis on lui passe à la construction ou par un setter après la construction
 * 
 * NOUVELLE STRUCTURE :
 * --------------------
 * 1) On ne construit plus directement les dépendances de ReportPrinter dans son constructeur
 * 2) On permet d'envoyer au ReportPrinter ce dont il a besoin directement en paramètres du constructeur
 * 3) On n'attend pas de formatter particulier dans le constructeur du ReportPrinter mais simplement
 * un FormatterInterface :D :D
 * 4) On créé le formatter qu'on souhaite et le Report qu'on souhaite nous même puis on les passe au ReportPrinter
 * lors de la construction
 * 
 * Magique !
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

// Désormais, on peut créer nous même les éléments qui seront utilisés par le ReportPrinter

// Je créé le rapport que je veux :
$report = new Report("2019-02-02", "Le rapport que je décide !");
// Je créé le formatter que je décide !
$formatter = new CsvFormatter();

// J'injecte les dépendances dans le ReportPrinter !
$reportPrinter = new ReportPrinter($report, $formatter);

$reportPrinter->print();
$reportPrinter->dump();
