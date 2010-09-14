<?php
       require_once('config.php');
       require_once('encode.php');
       $models = Doctrine_Core::loadModels('models');
       $aColumns = array( 'idhouses', 'name', 'city', 'tel', 'email', 'www' );

        //$houseTable = Doctrine_Core::getTable('House');
       // echo $houseTable->findAll();
      // $q = Doctrine_Query::create()
      //      ->select('h.idhouses, h.name, r.*')
       //     ->from('House h')
       //     ->innerJoin('h.Region r')
       //     ->limit(20);

       
        $q = Doctrine_Query::create()
        ->select('h.idhouses, h.name, h.city, h.tel, h.email, h.www')
        ->from("House h");
        
        /* Stronicowanie */
	$limit = 0;
        $offset = 0;
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$limit =  $_GET['iDisplayLength'];
		$offset = $_GET['iDisplayStart'];
	}

        /*
	 * Sortowanie
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
                            $q->addOrderBy('h.'.$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".$_GET['sSortDir_'.$i]);
				//$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."".$_GET['sSortDir_'.$i].", ";
			}
		}	
	}
        
       /*
        * Filtrowanie
        */
        if ( $_GET['sSearch'] != "" )
	{

                $q->addWhere('h.city LIKE ?', $_GET['sSearch'].'%');
		
	}
        
        $q->offset($offset)
          ->limit($limit);
        $iFilteredTotal=$q->count();
        $houses=$q->fetchArray();
        
        $q->free();
        $q = Doctrine_Query::create()
        ->select('h.idhouses')
        ->from("House h");
        $iTotal=$q->count();
        $q->free();
        
        /*
        $q = Doctrine_Query::create()
            ->select('h.idhouses, h.name, h.city, h.tel, h.email, h.www')
            ->from('House h')
            ->orderBy('h.idhouses')
            ->offset($offset)
            ->limit($limit);
       //echo $q->getSqlQuery();
       $houses=$q->fetchArray();
       */
           // $usersWithAddresses = $em->createQuery("select u, a from MyProject
          //  \Domain\User join u.addresses a")->getArrayResult();
           // $json = json_encode($usersWithAddresses);
            
           //print_r($houses[0]);
           $arrValues = Array();
           //$json = json_encode($houses[0]);
           //print_r( $arrValues);
          
          foreach ($houses as $house){
            //echo $house->name . ' '.$house->city.' '.$house->Region->name."<br>";
              array_push($arrValues, array_values($house));
               
           }
           foreach($arrValues as $key=>$arrValue) {
               for($j=0; $j<count($arrValue);$j++){
               $enter = strpos($arrValue[$j],chr(13));
               if ($enter !== false){
                  // echo $enter."\n";
                  
                  $arrValues[$key][$j] = preg_replace('/\s+/', ' ', $arrValues[$key][$j]);
                  // echo $arrValue[$j]."\n";
                  
                  
                  //substr_replace($arrValue[$j], '', $enter,10);
                  //echo str_replace (chr(13), '', $arrValue[$j]);
               }
                   
               }
               //array_push($arrValues[$key], "<a href=\"../edit.php?id=".$arrValues[$key][0]."\">Edytuj</a> <a href=\"../delete.php?id=".$arrValues[$key][0]."\">Usuń</a>");
               array_push($arrValues[$key], "<a href=\"../edit.php?id=".$arrValues[$key][0]."\">Edytuj</a> <a href=\"../delete.php?id=".$arrValues[$key][0]."\"  onclick=\"return confirm('Czy na pewno usunąc wpis?')\">Usuń</a>");
           }
           //print_r($arrValues);
   

        //     foreach($houses as $key => $value) {
       //   array_push($arrValues, array_values($value));
          //$array[$key] = $value->toArray();
         // print_r (array_values($value));


     //  }
      
           $sOutput = '{';
           $sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';
           $sOutput .= '"iTotalRecords": '.$iTotal.', ';
           $sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
           $sOutput .= '"aaData": ';
           $sOutput .= json_encode($arrValues);
           $sOutput .= ' }';
              
       echo $sOutput;

        
 ?>