<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('config.php');
require_once 'lib/swift/lib/swift_required.php';
$models = Doctrine_Core::loadModels('models');


  $packageTable = Doctrine_Core::getTable('Package');
  $package=Doctrine_Query::create()
           ->select("p.idpackages, h.email")
               ->from("Package p")
               ->innerJoin("p.House h")
               ->where("p.status=?",0)
               ->limit(100)
               ->fetchArray();

   $message = Swift_Message::newInstance();

    
    foreach ($package as $value) {

  //Give the message a subject
  $message->setSubject('Your subject')

  //Set the From address with an associative array
  ->setFrom(array('john@doe.com' => 'John Doe'))

  //Set the To addresses with an associative array
  ->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'))

  //Give it a body
  ->setBody('Here is the message itself')

  //And optionally an alternative body
  ->addPart('<q>Here is the message itself</q>', 'text/html')
  ->setReadReceiptTo('w.gesicki@o2.pl');



        print_r ($value);
}
  
    //$house->merge($_REQUEST['user']);
 
//    $house->name = $_POST['name'];
//    $house->city = $_POST['city'];
//    $house->zipCode = $_POST['zipCode'];
//    $house->street = $_POST['street'];
//    $house->tel = $_POST['tel'];
//    $house->email = $_POST['email'];
//    $house->www = $_POST['www'];
//    $house->target = $_POST['target'];
//    $house->save();
    //
    //echo($house->idhouses);
   



?>
