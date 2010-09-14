<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('config.php');
$models = Doctrine_Core::loadModels('models');
$idHouses = isset($_POST['id']) && $_POST['id'] > 0 ? $_POST['id']:null;
if (isset ($_POST['name']) && isset ($_POST['city']) && isset ($_POST['zipCode']) && isset ($_POST['street']))
{
    $houseTable = Doctrine_Core::getTable('House');
    if ($idHouses === null) {
        $house = new House();
    } else {
        $house = $houseTable->find($idHouses);
    }
  
    //$house->merge($_REQUEST['user']);
 
    $house->name = $_POST['name'];
    $house->city = $_POST['city'];
    $house->zipCode = $_POST['zipCode'];
    $house->street = $_POST['street'];
    $house->tel = $_POST['tel'];
    $house->email = $_POST['email'];
    $house->www = $_POST['www'];
    $house->target = $_POST['target'];
    $house->save();
    //
    //echo($house->idhouses);
    header('location: contacts/contacts.html');
}


?>
