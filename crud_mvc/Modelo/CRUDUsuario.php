<?php
class CRUDUsuario{
    public function __construct(){}

    public function VerificarLogin($Usuario)
    {
        $Db = Db::Conectar();
        $Sql = $Db->prepare("SELECT * FROM usuarios1 
        WHERE CorreoElectronico=:CorreoElectronico AND
        Contrasena=:Contrasena");
        $Sql->bindValue('CorreoElectronico',$Usuario->getCorreoElectronico());
        $Sql->bindValue('Contrasena',$Usuario->getContrasena());
        
        $Sql->execute();
        $U = new Usuario();
        if($Sql->rowCount() > 0)
        {
            $DatosUsuario = $Sql->fetch();
            $U->setIdUsuario($DatosUsuario['IdUsuario']);
            $U->setNombres($DatosUsuario['Nombres']);
            $U->setApellidos($DatosUsuario['Apellidos']);
            $U->setExiste(1);
        }
        else
        {
            $U->setExiste(0);
        }

        return $U;
    }

    public function ListarUsuarios(){
        //Conectar a la DB
        $Db = Db::Conectar();
        $ListaUsuarios = [];
        //Define la consulta
        $Sql = $Db->query('SELECT * FROM usuarios1');
        //Ejecuta la consulta
        $Sql->execute();
        foreach($Sql->fetchAll() as $Usuario){
            $U = new Usuario(); //Crear un objeto de tipo usuario
            $U->setIdUsuario($Usuario['IdUsuario']);
            $U->setTipoDocumento($Usuario['TipoDocumento']);
            $U->setNumeroDocumento($Usuario['NumeroDocumento']);
            $U->setNombres($Usuario['Nombres']);
            $U->setApellidos($Usuario['Apellidos']);
            $U->setCorreoElectronico($Usuario['CorreoElectronico']);
            $U->setIdEstado($Usuario['IdEstado']);
            $U->setIdRol($Usuario['IdRol']);
             $ListaUsuarios[] = $U; //Asisgar a la lista el objeto.
        }
        Db::CerrarConexion($Db); //LLamar el método para cerrar la conexión.
        return $ListaUsuarios; //Retornar el array de objetos.
    }

    public function RegistrarUsuario($Usuario){
        //Conectar a la DB
        $Db = Db::Conectar();
        //Definir el SQL
        $Sql = $Db->prepare('INSERT INTO usuarios1(
            TipoDocumento,NumeroDocumento,Nombres,Apellidos,
            CorreoElectronico,Contrasena,IdEstado,IdRol)
            VALUES(:TipoDocumento,:Documento,:Nombres,
            :Apellidos,:CorreoElectronico,:Contrasena,
            :IdEstado,:IdRol)');
            $Sql->bindValue('TipoDocumento',$Usuario->getTipoDocumento());
            $Sql->bindValue('Documento',$Usuario->getNumeroDocumento());
            $Sql->bindValue('Nombres',$Usuario->getNombres());
            $Sql->bindValue('Apellidos',$Usuario->getApellidos());
            $Sql->bindValue('CorreoElectronico',$Usuario->getCorreoElectronico());
            $Sql->bindValue('Contrasena',md5($Usuario->getNumeroDocumento()));
            $Sql->bindValue('IdEstado',$Usuario->getIdEstado());
            $Sql->bindValue('IdRol',$Usuario->getIdRol());
        var_dump($Sql);
            try{
                $Sql->execute();
                echo "Registro Exitoso";
            }
            catch(Exception $e){
                echo $e->getMessage();
                die();
            }
        Db::CerrarConexion($Db); //LLamar el método para cerrar la conexión.
    }

    public function EditarUsuario($Usuario){
        //Conectar a la DB
        $Db = Db::Conectar();
        //Definir el SQL
        $Sql = $Db->prepare('UPDATE usuarios1 SET
            TipoDocumento=:TipoDocumento,
            NumeroDocumento=:NumeroDocumento,
            Nombres=:Nombres,
            Apellidos=:Apellidos,
            CorreoElectronico=:CorreoElectronico,
            IdEstado=:IdEstado,
            IdRol=:IdRol
            WHERE IdUsuario=:IdUsuario');
            $Sql->bindValue('TipoDocumento',$Usuario->getTipoDocumento());
            $Sql->bindValue('NumeroDocumento',$Usuario->getNumeroDocumento());
            $Sql->bindValue('Nombres',$Usuario->getNombres());
            $Sql->bindValue('Apellidos',$Usuario->getApellidos());
            $Sql->bindValue('CorreoElectronico',$Usuario->getCorreoElectronico());
            $Sql->bindValue('IdEstado',$Usuario->getIdEstado());
            $Sql->bindValue('IdRol',$Usuario->getIdRol());
            $Sql->bindValue('IdUsuario',$Usuario->getIdUsuario());
        var_dump($Sql);
            try{
                $Sql->execute();
                echo "Actualización Exitosa";
            }
            catch(Exception $e){
                echo $e->getMessage();
                die();
            }
        Db::CerrarConexion($Db); //LLamar el método para cerrar la conexión.
    }

    public function BuscarUsuario($IdUsuario){
        //Conectar a la DB
        $Db = Db::Conectar();
        //$ListaUsuarios = [];
        //Define la consulta
       // $Sql = $Db->query("SELECT * FROM usuarios1 WHERE IdUsuario=$IdUsuario");
        $Sql = $Db->prepare('SELECT * FROM usuarios1 WHERE IdUsuario=:IdUsuario');
        $Sql->bindValue('IdUsuario',$IdUsuario);
        //Ejecuta la consulta
        $Sql->execute();
        foreach($Sql->fetchAll() as $Usuario){
            $U = new Usuario(); //Crear un objeto de tipo usuario
            $U->setIdUsuario($Usuario['IdUsuario']);
            $U->setTipoDocumento($Usuario['TipoDocumento']);
            $U->setNumeroDocumento($Usuario['NumeroDocumento']);
            $U->setNombres($Usuario['Nombres']);
            $U->setApellidos($Usuario['Apellidos']);
            $U->setCorreoElectronico($Usuario['CorreoElectronico']);
            $U->setIdEstado($Usuario['IdEstado']);
            $U->setIdRol($Usuario['IdRol']);
            //$ListaUsuarios[] = $U; //Asisgar a la lista el objeto.
        }
        Db::CerrarConexion($Db); //LLamar el método para cerrar la conexión.
        return $U; //Retornar el array de objetos.
    }

    public function EliminarUsuario($IdUsuario){
        //Conectar a la DB
        $mensaje = "";
        $Db = Db::Conectar();
        $Sql = $Db->prepare('DELETE FROM usuarios1 WHERE IdUsuario=:IdUsuario');
        $Sql->bindValue('IdUsuario',$IdUsuario);
        //Ejecuta la consulta
        try{
            $Sql->execute();
            $mensaje=1;
        }
        catch(Exception $e){
            $mensaje=$e->getMessage();
        }
    Db::CerrarConexion($Db); //LLamar el método para cerrar la conexión.
    return $mensaje;
}


}

?>