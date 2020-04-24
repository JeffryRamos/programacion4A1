<?php 
include('../../Config/Config.php');
$alumno = new alumno($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$alumno->$proceso( $_GET['alumno'] );
print_r(json_encode($alumno->respuesta));

class alumno{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($alumno){
        $this->datos = json_decode($alumno, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['nombre']) ){
            $this->respuesta['msg'] = 'por favor ingrese el nombre del estudiante';
        }
        if( empty($this->datos['direccion']) ){
            $this->respuesta['msg'] = 'por favor ingrese la direccion del estudiante';
        }
        $this->almacenar_alumno();
    }
    private function almacenar_alumno(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO alumnos (nombre,direccion,telefono,seccion,nie,grado,email) VALUES(
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['direccion'] .'",
                        "'. $this->datos['telefono'] .'",
                        "'. $this->datos['seccion'] .'",
                        "'. $this->datos['nie'] .'",
                        "'. $this->datos['grado'] .'",
                        "'. $this->datos['email'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                   UPDATE alumnos SET
                        nombre     = "'. $this->datos['nombre'] .'",
                        direccion     = "'. $this->datos['direccion'] .'",
                        telefono  = "'. $this->datos['telefono'] .'",
                        seccion  = "'. $this->datos['seccion'] .'",
                        nie  = "'. $this->datos['nie'] .'",
                        grado  = "'. $this->datos['grado'] .'",
                        email   = "'. $this->datos['email'] .'"
                    WHERE idAlumno = "'. $this->datos['idAlumno'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            }
        }
    }
    public function buscarAlumno($valor=''){
        $this->db->consultas('
            select alumnos.idAlumno, alumnos.nombre, alumnos.direccion, alumnos.telefono, alumnos.seccion, alumnos.nie, alumnos.grado, alumnos.email
            from alumnos
            where alumnos.nombre like "%'. $valor .'%" or alumnos.telefono like "%'. $valor .'%" or alumnos.nie like "%'.$valor.'%"
        ');
        return $this->respuesta = $this->db->obtener_datos();
    }
    public function eliminarAlumno($idAlumno=''){
        $this->db->consultas('
            delete alumnos
            from alumnos
            where alumnos.idAlumno = "'.$idAlumno.'"
        ');
        $this->respuesta['msg'] = 'Registro eliminado correctamente';
    }
}
?>