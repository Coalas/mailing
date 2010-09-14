<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('config.php');
$models = Doctrine_Core::loadModels('models');
$idHouses = isset($_GET['id']) && $_GET['id'] > 0 ? $_GET['id']:null;
if ($idHouses === null) {
       header('location: contacts/contacts.html');
    } else {
        $houseTable = Doctrine_Core::getTable('House');
        $house = $houseTable->find($idHouses);
        $house->delete();
        $house->free();
    }
    header('location: contacts/contacts.html');
?>
