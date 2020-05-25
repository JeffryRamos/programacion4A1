<?php 
include('../../Config/Config.php');
$prestamoe = new prestamoe($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$prestamoe->$proceso( $_GET['prestamoe'] );
print_r(json_encode($prestamoe->respuesta));

class prestamoe{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($prestamoe){
        $this->datos = json_decode($prestamoe, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['estudiante']['id']) ){
            $this->respuesta['msg'] = 'Por favor ingrese el estudiante del prestamo';
        }
        if( empty($this->datos['libro']['id']) ){
            $this->respuesta['msg'] = 'Por favor ingrese el libro';
        }
        if( empty($this->datos['fechaPrestamo']) ){
            $this->respuesta['msg'] = 'Por favor ingrese la fecha';
        }
        $this->almacenar_prestamoe();
    }
    private function almacenar_prestamoe(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO prestamose (idEstudiante,idLibro,fechaPrestamo,fechaDevolucion) VALUES(
                        "'. $this->datos['estudiante']['id'] .'",
                        "'. $this->datos['libro']['id'] .'",
                        "'. $this->datos['fechaPrestamo'] .'",
                        "'. $this->datos['fechaDevolucion'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE prestamose SET
                        idEstudiante     = "'. $this->datos['estudiante']['id'] .'",
                        idLibro      = "'. $this->datos['libro']['id'] .'",
                        fechaPrestamo         = "'. $this->datos['fechaPrestamo'] .'",
                        fechaDevolucion         = "'. $this->datos['fechaDevolucion'] .'"
                    WHERE idPrestamoe = "'. $this->datos['idPrestamoe'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            }
        }
    }
    public function buscarPrestamoe($valor = ''){
        if( substr_count($valor, '-')===2 ){
            $valor = implode('-', array_reverse(explode('-',$valor)));
        }
        $this->db->consultas('
            select prestamose.idPrestamoe, prestamose.idEstudiante, prestamose.idLibro, 
                date_format(prestamose.fechaPrestamo,"%d-%m-%Y") AS fechaPrestamo, prestamose.fechaPrestamo AS f,
                date_format(prestamose.fechaDevolucion,"%d-%m-%Y") AS fechaDevolucion, prestamose.fechaDevolucion AS d,
                libros.codigo, libros.titulo, 
                estudiantes.nie, estudiantes.nombre

            from prestamose
                inner join libros on(libros.idLibro=prestamose.idLibro)
                inner join estudiantes on(estudiantes.idEstudiante=prestamose.idEstudiante)

            where libros.titulo like "%'. $valor .'%" or estudiantes.nombre like "%'. $valor .'%" or prestamose.fechaPrestamo like "%'. $valor .'%" or prestamose.fechaDevolucion like "%'. $valor .'%"

        ');
        $prestamose = $this->respuesta = $this->db->obtener_data();
        foreach ($prestamose as $key => $value) {
            $datos[] = [
                'idPrestamoe' => $value['idPrestamoe'],
                'libro'      => [
                    'id'      => $value['idLibro'],
                    'label'   => $value['titulo']
                ],
                'estudiante'      => [
                    'id'      => $value['idEstudiante'],
                    'label'   => $value['nombre']
                ],
                'fechaPrestamo'       => $value['f'],
                'f'           => $value['fechaPrestamo'],

                'fechaDevolucion'       => $value['d'],
                'd'           => $value['fechaDevolucion']

            ]; 
        }
        return $this->respuesta = $datos;
    }
    public function traer_estudiante_libro(){
        $this->db->consultas('
            select estudiantes.nombre AS label, estudiantes.idEstudiante AS id
            from estudiantes
        ');
        $estudiantes = $this->db->obtener_data();
        $this->db->consultas('
            select libros.libro AS label, libros.idLibro AS id
            from libros
        ');
        $libros = $this->db->obtener_data();
        return $this->respuesta = ['estudiantes'=>$estudiantes, 'libros'=>$libros ];//array de php en v7+
    }
    public function eliminarPrestamoe($idPrestamoe = 0){
        $this->db->consultas('
            DELETE prestamose
            FROM prestamose
            WHERE prestamose.idPrestamoe="'.$idPrestamoe.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>