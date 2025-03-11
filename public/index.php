<?php 
//C'est la seul ligne que j'aurais sur tous mes fichiers de /public 
require '../bootstrap.php';
//C'est la seule ligne que j'aurais sur tous mes fichiers de /public

// On importe la classe Model
use Awl\Orm\User;
use Awl\Orm\Course;

// On instancie un nouvel objet Model en lui passant le nom de la table
$modelUser = (new User())->eleves();    
$coursesList = (new Course)->getByHours(3);


echo '<pre>';
print_r($modelUser);
echo '</pre>';

echo '<pre>';
// Affichage des résultats
print_r($coursesList);
echo '</pre>';

$user = new User();
$user
    ->set('name', 'Pierre durandeleao')
    ->where('name', 'Pierre durand')
    ->update();
?>