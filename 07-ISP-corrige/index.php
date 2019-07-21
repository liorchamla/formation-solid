<?php

use Reporting\Format\JsonFormatter;

/**
 * 
 * PREALABLE AU COURS :
 * --------------------
 * Bien comprendre la notion d'interface et être au courant du fait qu'on puisse implémenter plusieurs
 * interfaces pour une même classe :-)
 * 
 * COURS :
 * -------
 * Cet exercice traite du I de SOLID (Interfaces Segregation Principle - Principe de Ségrégation (wtf?!)
 *  d'Interfaces) : c'est en gros le SRP, mais appliqué aux interfaces !
 * 
 * L'idée de ce principe est d'être conscient, lorsque l'on définit une interface (dont le but est de définir
 * quelles seront les méthodes que doivent posséder les classes qui s'en réclament), qu'on ne doit pas demander
 * à une classe de savoir faire à la fois le café, le thé, la lessive et des calculs mathématique.
 * 
 * C'est un complément logique du SRP (Principe de Responsabilité Unique) : si vous créez une interface qui demande
 * à une classe qui veut l'implémenter de faire à la fois le café et la lessive, comment voulez vous en vouloir
 * au développeur qui va créer une classe à partir de cette interface d'avoir créé une classe qui a plusieurs
 * rôles / responsabilités ?
 * 
 * CA SERA VOTRE FAUTE ! Et on aboutira à un code dégueu qui ne respecte pas le SRP, parce que dans un premier 
 * temps, c'est votre interface qui ne respecte pas l'ISP !
 * 
 * Vous devez donc veiller à ce que votre interface ne contiennent que des méthodes qui sont liées par un même
 * rôle à jouer.
 * 
 * Par exemple, on pourrait imaginer une interface CoffeeMakerInterface qui ait 3 ou 4 méthodes liées 
 * au fait de faire du café (moudreGrains(), chaufferEau(), faireCouler() ...) mais rien qui soit en rapport
 * avec le fait de faire la vaisselle ! Vous mettriez plutôt ça dans une autre interface WashingInterface !
 * 
 * L'avantage c'est que si un jour on invente une machine à café qui fait aussi la vaisselle, la classe pourra
 * tout à fait implémenter les deux interfaces :-)
 * 
 * 
 * 
 * CORRIGE DE L'EXERCICE
 * ---------------------
 * Ce corrigé n'engage que l'auteur de ces lignes, évidemment vous avez peut-être décidé d'une stratégie
 * tout à fait différente avec votre prof, et c'est ce qui est beau dans le développement : Il n'y a jamais
 * qu'une seule et même solution à un problème ! :-)
 * 
 * Questions à discuter avec votre prof :
 * --------------------------------------
 * Question 1 : Cela a-t-il du sens d'avoir une fonction qui n'existe que pour émettre une exception ?
 * => Ce n'est que l'avis du prof qui rédige ces lignes, mais ça me semble COMPLETEMENT DEBILE. Une exception
 * c'est une situation qui échape à la règle. Or une fonction qui enverrait dans tous les cas une exception, 
 * ce n'est plus une exception, c'est la règle du coup !
 * 
 * Question 2 : Peut-on envisager que les classes XXXFormatter aient toutes la méthode format() mais que 
 * seules certaines d'entre elles ne possèdent la méthode deserialize() ?
 * => Tout à fait, c'est d'ailleurs la solution de cet exercice : on peut très bien avoir une interface
 * FormatterInterface qui serait implémentée par tous nos Formatters avec la méthode `format()` et UNE AUTRE
 * INTERFACE DeserializeInterface qui ne serait implémentée que par les Formatters où il fait sens d'avoir 
 * une méthode `deserialize()` !
 * 
 * NOUVELLE STRUCTURE :
 * --------------------
 * 1) On a tout simplement créer une nouvelle interface DeserializeInterface qui contient la méthode 
 * `deserialize()`
 * 2) On a pu virer cette méthode dans le HtmlFormatter et dans le CsvFormatter
 * 3) On l'a laissé dans le JsonFormatter puisque ça a du sens et on a bien précisé que le JsonFormatter implémente
 * désormais 2 interfaces : la FormatterInterface et aussi la DeserializeInterface :-)
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

// On imagine simplement le json suivant
$json = '{"date":"2016-04-21","title":"Titre de mon rapport"}';

// On créé le JsonFormatter
$jsonFormatter = new JsonFormatter();

// On créé le rapport avec la méthode deserialize()
$report = $jsonFormatter->deserialize($json);

// Le var_dump() devrait marcher
var_dump($report);
