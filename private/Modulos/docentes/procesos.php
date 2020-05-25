<?php 
include('../../Config/Config.php');
$docente = new docente($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$docente->$proceso( $_GET['docente'] );
print_r(json_encode($docente->respuesta));

class docente{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($docente){
        $this->datos = json_decode($docente, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty(trim($this->datos['codigo'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el codigo del docente';
        }
        if( empty(trim($this->datos['nombre'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el nombre del docente';
        }
        if( empty( trim($this->datos['direccion'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese la direccion del docente';
        }
        $this->almacenar_docente();
    }
    private function almacenar_docente(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO docentes (codigo,nombre,direccion,telefono,dui,nit,email) VALUES(
                        "'. $this->datos['codigo'] .'",
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['direccion'] .'",
                        "'. $this->datos['telefono'] .'",
                        "'. $this->datos['dui'] .'",
                        "'. $this->datos['nit'] .'",
                        "'. $this->datos['email'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE docentes SET
                        codigo     = "'. $this->datos['codigo'] .'",
                        nombre     = "'. $this->datos['nombre'] .'",
                        direccion  = "'. $this->datos['direccion'] .'",
                        telefono   = "'. $this->datos['telefono'] .'",
                        dui   = "'. $this->datos['dui'] .'",
                        nit   = "'. $this->datos['nit'] .'",
                        email   = "'. $this->datos['email'] .'"
                    WHERE idDocente = "'. $this->datos['idDocente'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            } else{
                $this->respuesta['msg'] = 'Error, no se envio la accion a realizar';
            }
        }
    }
    public function buscarDocente($valor = ''){
        $this->db->consultas('
            select docentes.idDocente, docentes.codigo, docentes.nombre, docentes.direccion, docentes.telefono, docentes.dui, docentes.nit, docentes.email
            from docentes
            where docentes.codigo like "%'. $valor .'%" or docentes.nombre like "%'. $valor .'%" or docentes.dui like "%'. $valor .'%" or docentes.nit like "%'. $valor .'%"

        ');
        return $this->respuesta = $this->db->obtener_data();
    }
    public function eliminarDocente($idDocente = 0){
        $this->db->consultas('
            DELETE docentes
            FROM docentes
            WHERE docentes.idDocente="'.$idDocente.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>