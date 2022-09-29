<?php
    require '../../model/usuario/Usuario.php';

    $mUsuario = new Usuario();
    $idusuario = htmlspecialchars($_POST['idusuario'], ENT_QUOTES, 'UTF-8');
    $contrabd = htmlspecialchars($_POST['contrabd'], ENT_QUOTES, 'UTF-8');
    $contraescrita1 = htmlspecialchars($_POST['contraescrita'], ENT_QUOTES, 'UTF-8');

    $contranu1 = htmlspecialchars($_POST['contranu'], ENT_QUOTES, 'UTF-8');

    $contranu = hash("SHA256",$contranu1);

    $contraescrita = hash("SHA256",$contraescrita1);

    if($contraescrita ==  $contrabd){
        $consulta = $mUsuario->modificarContraUsuario($idusuario,$contranu);
        echo $consulta;
    }else{
        echo 2;
    }

    

   
?>