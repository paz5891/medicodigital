<?php
class Usuario
{
    private $conexion;
    function __construct()
    {
        require_once 'conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar();
    }
    //funcion para verificar usuario
    function VerificarUsuario($usuario, $contra)
    {
        $sql = "call SP_VERIFICAR_USUARIO('$usuario')";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
            while ($consulta_VU = mysqli_fetch_array($consulta)) {
                if (password_verify($contra, $consulta_VU["constrasenausu"])) {
                    $arreglo[] = $consulta_VU;
                }
            }
            return $arreglo;
            $this->conexion->cerrar();
        }
    }
 

    //cambiar contraseña
    function modificarContraUsuario($idusuario, $contranu)
    {
        $sql = "call sp_modificar_contra_usuario('$idusuario','$contranu')";
        if ($consulta = $this->conexion->conexion->query($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    ///fin cambio de contraseña

  
    //RESTABLECER CONTRASEÑA
    function restablecerContra($email, $contra)
    {
        $sql = "call sp_restablecer_contra('$email','$contra')";
        if ($consulta = $this->conexion->conexion->query($sql)) {
            if ($row = mysqli_fetch_array($consulta)) {
                return $id = trim($row[0]);
            }

            $this->conexion->cerrar();
        }
    }
}

?>
