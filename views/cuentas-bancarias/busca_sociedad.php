<?php
include('sentenciasSql.php');
include('pathparams.php');
    $consult = new Consult;
    $conect = $consult->conection();  
    $catdirecciones="nmdev_common";  
    $conect ->select_db($catdirecciones);
    $dato=$_REQUEST['dato'];
    $opc=$_REQUEST['opc'];
    switch ($opc) {
        case 1:
            $esta=$conect->query('select DISTINCT(Estado) from cat_direcciones where Pais="'.$_REQUEST['pais'].'"');
            echo ' <option  selected>-Eliga un Estado-</option>';
            while($estado=$esta->fetch_array(MYSQLI_ASSOC)){
                echo '<option  id="'.$estado['Estado'].' ">'.$estado['Estado'].'</option>'; 
            }; 
            break;  
        case 2:
            $muni=$conect->query('select DISTINCT(Municipio) from cat_direcciones where pais = "'.$_REQUEST['pais'].'" and estado="'.$_REQUEST['estado'].'"');
            echo ' <option  selected>-Eliga un Municipio-</option>';
            while($municipio=$muni->fetch_array(MYSQLI_ASSOC)){ 
                echo '<option  id="'.$municipio['Municipio'].' ">'.$municipio['Municipio'].'</option>'; 
            };
            break;
        case 3:
            $colo=$conect->query('select DISTINCT(Colonia) from cat_direcciones where pais = "'.$_REQUEST['pais'].'" and estado="'.$_REQUEST['estado'].'" and Municipio="'.$_REQUEST['mpio'].'"');
            echo ' <option  selected>-Eliga una Colonia-</option>';
            while($colonia=$colo->fetch_array(MYSQLI_ASSOC)){ 
                echo '<option  id="'.$colonia['Colonia'].' ">'.$colonia['Colonia'].'</option>'; 
            };
            break;
        case 4:
            $estado=$_REQUEST['estado'];
            $municipio=$_REQUEST['municipio'];
            $codi=$conect->query('select DISTINCT(CP),Id from cat_direcciones where pais = "'.$_REQUEST['pais'].'" and estado="'.$_REQUEST['estado'].'" and Municipio="'.$_REQUEST['mpio'].'" and Colonia="'.$_REQUEST['colonia'].'"');
            echo ' <option  selected>-Eliga un CP-</option>';
            while($cp=$codi->fetch_array(MYSQLI_ASSOC)){ 
                echo '<option value="'.$cp['Id'].'" id="'.$cp['CP'].' ">'.$cp['CP'].'</option>'; 
            };
            break;
    };
   
    
?>