<?php 
include('../../config/config.php');
$prestamo = new prestamo($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$prestamo->$proceso( $_GET['prestamo'] );
print_r(json_encode($prestamo->respuesta));

class prestamo{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($prestamo){
        $this->datos = json_decode($prestamo, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['estudiante']['id']) ){
            $this->respuesta['msg'] = 'por favor ingrese el nombre del estudiante';
        }
        if( empty($this->datos['libro']['id']) ){
            $this->respuesta['msg'] = 'por favor ingrese la libro';
        }
        if( empty($this->datos['prestamo']) ){
            $this->respuesta['msg'] = 'por favor ingrese el valor';
        }
        $this->almacenar_prestamo();
    }
    private function almacenar_prestamo(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO prestamo (idestudiante,idlibro,prestamo,devolucion,valor) VALUES(
                        "'. $this->datos['estudiante']['id'] .'",
                        "'. $this->datos['libro']['id'] .'",
                        "'. $this->datos['prestamo'] .'",
                        "'. $this->datos['devolucion'] .'",
                        "'. $this->datos['valor'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE prestamo SET
                        idestudiante     = "'. $this->datos['estudiante']['id'] .'",
                        idlibro      = "'. $this->datos['libro']['id'] .'",
                        prestamo   = "'. $this->datos['prestamo'] .'",
                        devolucion   = "'. $this->datos['devolucion'] .'",
                        valor             = "'. $this->datos['valor'] .'"
                    WHERE idPrestamo = "'. $this->datos['idPrestamo'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            }
        }
    }
    public function buscarPrestamo($valor = ''){
        if( substr_count($valor, '-')===2 ){
            $valor = implode('-', array_reverse(explode('-',$valor)));
        }
        $this->db->consultas('
            select prestamo.idPrestamo, prestamo.idestudiante, prestamo.idlibro, prestamo.valor,
                date_format(prestamo.prestamo,"%d-%m-%Y") AS prestamo, prestamo.prestamo AS f, 
                date_format(prestamo.devolucion,"%d-%m-%Y") AS devolucion, prestamo.devolucion AS d,
                
                libros.genero, libros.codigo, 
                estudiantes.dui, estudiantes.nombre,
                prestamo.valor AS v

            from prestamo
                inner join libros on(libros.idlibro=prestamo.idlibro)
                inner join estudiantes on(estudiantes.idestudiante=prestamo.idestudiante)
            where libros.codigo like "%'. $valor .'%" or 
                estudiantes.nombre like "%'. $valor .'%" or 
                prestamo.prestamo like "%'. $valor .'%" or
                prestamo.devolucion like "%'. $valor .'%"

        ');
        $prestamos = $this->respuesta = $this->db->obtener_data();
        foreach ($prestamos as $key => $value) {
            $datos[] = [
                'idPrestamo' => $value['idPrestamo'],
                'libro'      => [
                    'id'      => $value['idlibro'],
                    'label'   => $value['codigo']
                ],
                'estudiante'      => [
                    'id'      => $value['idestudiante'],
                    'label'   => $value['nombre']
                ],
                'prestamo'       => $value['f'],
                'f'           => $value['prestamo'],

                'devolucion'       => $value['d'],
                'd'           => $value['devolucion'],

                'valor'       => $value['v'],
                'v'           => $value['valor']
            ]; 
        }
        return $this->respuesta = $datos;
    }


    public function traer_estudiante_libro(){
        $this->db->consultas('
            select estudiantes.nombre AS label, estudiantes.idestudiante AS id
            from estudiantes
        ');
        $estudiantes = $this->db->obtener_data();
        $this->db->consultas('
            select libros.codigo AS label, libros.idlibro AS id
            from libros
        ');
        $libros = $this->db->obtener_data();
        return $this->respuesta = ['estudiantes'=>$estudiantes, 'libros'=>$libros ];
    }
    public function eliminarPrestamo($idPrestamo = 0){
        $this->db->consultas('
            DELETE prestamo
            FROM prestamo
            WHERE prestamo.idPrestamo="'.$idPrestamo.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>