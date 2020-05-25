<?php 
include('../../Config/Config.php');
$estudiante = new estudiante($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$estudiante->$proceso( $_GET['estudiante'] );
print_r(json_encode($estudiante->respuesta));

class estudiante{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($estudiante){
        $this->datos = json_decode($estudiante, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty(trim($this->datos['nie'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el nie del estudiante';
        }
        if( empty(trim($this->datos['nombre'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el nombre del estudiante';
        }
        if( empty( trim($this->datos['direccion'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese la direccion del estudiante';
        }
        $this->almacenar_estudiante();
    }
    private function almacenar_estudiante(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO estudiantes (nie,nombre,direccion,telefono,seccion,grado,email) VALUES(
                        "'. $this->datos['nie'] .'",
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['direccion'] .'",
                        "'. $this->datos['telefono'] .'",
                        "'. $this->datos['seccion'] .'",
                        "'. $this->datos['grado'] .'",
                        "'. $this->datos['email'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE estudiantes SET
                        nie     = "'. $this->datos['nie'] .'",
                        nombre     = "'. $this->datos['nombre'] .'",
                        direccion  = "'. $this->datos['direccion'] .'",
                        telefono   = "'. $this->datos['telefono'] .'",
                        seccion   = "'. $this->datos['seccion'] .'",
                        grado   = "'. $this->datos['grado'] .'",
                        email   = "'. $this->datos['email'] .'"
                    WHERE idEstudiante = "'. $this->datos['idEstudiante'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            } else{
                $this->respuesta['msg'] = 'Error, no se envio la accion a realizar';
            }
        }
    }
    public function buscarEstudiante($valor = ''){
        $this->db->consultas('
            select estudiantes.idEstudiante, estudiantes.nie, estudiantes.nombre, estudiantes.direccion, estudiantes.telefono, estudiantes.seccion, estudiantes.grado, estudiantes.email
            from estudiantes
            where estudiantes.nie like "%'. $valor .'%" or estudiantes.nombre like "%'. $valor .'%" or estudiantes.telefono like "%'. $valor .'%"

        ');
        return $this->respuesta = $this->db->obtener_data();
    }
    public function eliminarEstudiante($idEstudiante = 0){
        $this->db->consultas('
            DELETE estudiantes
            FROM estudiantes
            WHERE estudiantes.idEstudiante="'.$idEstudiante.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>