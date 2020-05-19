<?php 
include('../../Config/Config.php');
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
            $this->respuesta['msg'] = 'Por favor ingrese el estudiante del prestamo';
        }
        if( empty($this->datos['libro']['id']) ){
            $this->respuesta['msg'] = 'Por favor ingrese el libro';
        }
        $this->almacenar_prestamo();
    }
    private function almacenar_prestamo(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO prestamos (idEstudiante,idLibro,fechaPrestamo,fechaDevolucion) VALUES(
                        "'. $this->datos['estudiante']['id'] .'",
                        "'. $this->datos['libro']['id'] .'",
                        "'. $this->datos['fechaPrestamo'] .'",
                        "'. $this->datos['fechaDevolucion'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE prestamos SET
                        idEstudiante     = "'. $this->datos['estudiante']['id'] .'",
                        idLibro      = "'. $this->datos['libro']['id'] .'",
                        fechaPrestamo         = "'. $this->datos['fechaPrestamo'] .'"
                        fechaDevolucion         = "'. $this->datos['fechaDevolucion'] .'"
                    WHERE idPrestamo = "'. $this->datos['idPrestamo'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            }
        }
    }
    public function buscarPrestamos($valor = ''){
        if( substr_count($valor, '-')===2 ){
            $valor = implode('-', array_reverse(explode('-',$valor)));
        }
        $this->db->consultas('
            select prestamos.idPrestamo, prestamos.idEstudiante, prestamos.idLibro, 
                date_format(prestamos.fechaPrestamo,"%d-%m-%Y") AS fechaPrestamo, prestamos.fechaPrestamo AS f,
                date_format(prestamos.fechaDevolucion,"%d-%m-%Y") AS fechaDevolucion, prestamos.fechaDevolucion AS d,  
                estudiantes.nie, estudiantes.nombre, 
                libros.codigo, libros.titulo
            from libros
                inner join estudiantes on(estudiantes.idEstudiante=prestamos.idEstudiante)
                inner join libros on(libros.idLibro=prestamos.idLibro)
            where estudiantes.nombre like "%'. $valor .'%" or 
                libros.titulo like "%'. $valor .'%" or 
                prestamos.fechaPrestamo like "%'. $valor .'%" or 
                prestamos.fechaDevolucion like "%'. $valor .'%"
        ');
        $prestamos = $this->respuesta = $this->db->obtener_data();
        foreach ($prestamos as $key => $value) {
            $datos[] = [
                'idPrestamo' => $value['idPrestamo'],
                'estudiante'      => [
                    'id'      => $value['idEstudiante'],
                    'label'   => $value['nombre']
                ],
                'libro'      => [
                    'id'      => $value['idLibro'],
                    'label'   => $value['titulo']
                ],
                'fechaPrestamo'       => $value['f'],
                'f'           => $value['fechaPrestamo']
                'fechaDevolucion'       => $value['d'],
                'd'           => $value['fechaDevolucion']

            ]; 
        }
        return $this->respuesta = $datos;
    }
    public function traer_estudiantes_libros(){
        $this->db->consultas('
            select estudiantes.nombre AS label, estudiantes.idEstudiante AS id
            from estudiantes
        ');
        $estudiantes = $this->db->obtener_data();
        $this->db->consultas('
            select libros.titulo AS label, libros.idLibro AS id
            from libros
        ');
        $libros = $this->db->obtener_data();
        return $this->respuesta = ['estudiantes'=>$estudiantes, 'libros'=>$libros ];//array de php en v7+
    }
    public function eliminarPrestamo($idPrestamo = 0){
        $this->db->consultas('
            DELETE prestamos
            FROM prestamos
            WHERE prestamos.idPrestamo="'.$idPrestamo.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>