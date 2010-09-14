<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once('config.php');
        $models = Doctrine_Core::loadModels('models');
        if (isset ($_POST['data'])){
            $recipients=explode(',',$_POST['data']);
            $houseTable = Doctrine_Core::getTable('House');
            $stored=Array();
            $rejected=Array();
            foreach ($recipients as $value) {

                $house = $houseTable->find($value);
                if ($house->email !== null){

                $package= new Package();
                $package->recipient =$value;
                $package->status=0;
                $package->save();
                $package->free();
                array_push($stored, $house->name." ".$house->city);
                } else
                    array_push ($rejected, $house->name." ".$house->city);
                $house->free();
            }
          echo "Dodano nastepujacych odbiorców:\n";
          foreach ($stored as $value) {
              echo $value."<br/>";
          }
          echo "Brak adresow email nastepujacych odbiorców:\n";
          foreach ($rejected as $value) {
              echo $value."<br/>";
          }

        }

        
        
       
        ?>
    </body>
</html>
