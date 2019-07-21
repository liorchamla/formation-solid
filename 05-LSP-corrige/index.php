<?php

use Office\Employee;
use Office\Developer;
use Office\Tester;

/** 
 * COURS :
 * -------
 * Cet exercice traite du L de SOLID (Liskov Substition Principle - Principe de Substitution de Liskov)
 * Ce principe postule simplement qu'une méthode qui utilise une classe A doit pouvoir utiliser une classe B qui
 * hérite de A sans même s'en rendre compte.
 * 
 * On devrait pouvoir appeler A->methode() et B->methode() en envoyant exactement les mêmes paramètres et en 
 * recevant le même type de retour ! Evidemment rien n'empêche B->methode() de faire quelque chose de radicalement
 * différent de A->methode(). Le tout est que les paramètres soient les mêmes et que le type de retour soit le 
 * même aussi !
 * 
 * Dans le langage PHP moderne, ce principe est pratiquement gravé dans le langage : en effet, quand on créé
 * une classe B qui hérite de la classe A et qu'on souhaite redéfinir une méthode de A dans B, PHP nous interdit
 * de changer la signature de la méthode.
 * 
 * Par exemple, si A possède une méthode `format(Report $report): string`, il nous sera interdit dans B de 
 * redéfinir la méthode tel que `format(string $report): array` par exemple. PHP va nous gueuler dessus
 * si on tente de le faire !
 * 
 * Mais il subsiste des cas où vous devrez faire attention, notamment les cas dans lesquels le type hinting n'est
 * pas utilisé. Par exemple, si A possède une méthode `format($report)` qui ne précise pas les types. On sait 
 * néanmoins que cette méthode doit recevoir un objet de la classe Report et retourner une chaine.
 * 
 * Rien ne vous empêcherait dans B de redéfinir la méthode  `format($report)` en gardant la même signature 
 * mais en recevant une string et en renvoyant un tableau. 
 * 
 * => Vous ne respecteriez pas dans ce cas le principe de substitution de Liskov !
 * 
 * CORRIGE DE L'EXERCICE
 * ----------------------
 * Bon c'était très con mais en fait notre collègue ne respectait pas le LSP ! Et oui : la classe Tester avait
 * redéfini la méthode work() de l'employé mais sans respecter son type de retour. Elle renvoyait un array au
 * lieu d'une simple chaine de caractères ..
 * 
 * On lui a donc remonté les bretelles et on lui a montré qu'en corrigeant la méthode work() de la classe Tester,
 * Anne la testeuse était bien rentrée dans le rang !
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

// On créé des employés, développeurs et testeurs
$george = new Employee("Georges", "Dupont");
$julie = new Developer("Julie", "Bensalah");
$anne = new Tester("Anne", "Durand");

// On appelle la même fonction pour chaque employé :
faireBosser($george);
faireBosser($julie);
faireBosser($anne);

// On a une fonction qui affiche le boulot de chacun
function faireBosser(Employee $employe)
{
    echo $employe->work();
    echo "<hr/>";
}
