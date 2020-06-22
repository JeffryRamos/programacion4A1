<?php
/** Clase principal de conexion a la base de datos desde PHP -> MySQ */
class DB{
    private $conexion, $result;
/**donde se debe conectar con el servidor de mysqli para guardar informacion en la base de datos */
    public function DB($server,$user, $pass,$db){
        $this->conexion = mysqli_connect($server,$user,$pass,$db) or die('No se pudo conectar al Server de BD');
    }
    /**donde da respuestas de conexcion con la base de datos  */
    public function consultas($sql){
        $this->result = mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
    }
    /**aqui se obtiene los datos necesarios de la base de datos */
    public function obtener_data(){
        return $this->result->fetch_all(MYSQLI_ASSOC);
    }
    /**manda la respuesta de dicha consulta */
    public function obtener_respuesta(){
        return $this->result;
    }
    public function id(){
        return $this->result->id();
    }
}

?>