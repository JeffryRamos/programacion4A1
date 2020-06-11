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
        if( empty($this->datos['usuario']['id']) ){
            $this->respuesta['msg'] = 'Por favor ingrese el usuario del prestamo';
        }
        if( empty($this->datos['libro']['id']) ){
            $this->respuesta['msg'] = 'Por favor ingrese el libro';
        }
        if( empty($this->datos['fechaPrestamo']) ){
            $this->respuesta['msg'] = 'Por favor ingrese la fecha';
        }
        $this->almacenar_prestamo();
    }
    private function almacenar_prestamo(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO prestamos (idRegistro,idLibro,fechaPrestamo,fechaDevolucion) VALUES(
                        "'. $this->datos['usuario']['id'] .'",
                        "'. $this->datos['libro']['id'] .'",
                        "'. $this->datos['fechaPrestamo'] .'",
                        "'. $this->datos['fechaDevolucion'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE prestamos SET
                        idRegistro     = "'. $this->datos['usuario']['id'] .'",
                        idLibro      = "'. $this->datos['libro']['id'] .'",
                        fechaPrestamo         = "'. $this->datos['fechaPrestamo'] .'",
                        fechaDevolucion         = "'. $this->datos['fechaDevolucion'] .'"
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
            select prestamos.idPrestamo, prestamos.idRegistro, prestamos.idLibro, 
                date_format(prestamos.fechaPrestamo,"%d-%m-%Y") AS fechaPrestamo, prestamos.fechaPrestamo AS f,
                date_format(prestamos.fechaDevolucion,"%d-%m-%Y") AS fechaDevolucion, prestamos.fechaDevolucion AS d,
                libros.codigo, libros.titulo, 
                registros.nombre, registros.usuario

            from prestamos
                inner join libros on(libros.idLibro=prestamos.idLibro)
                inner join registros on(registros.idRegistro=prestamos.idRegistro)

            where libros.titulo like "%'. $valor .'%" or registros.usuario like "%'. $valor .'%" or prestamos.fechaPrestamo like "%'. $valor .'%" or prestamos.fechaDevolucion like "%'. $valor .'%"

        ');
        $prestamos = $this->respuesta = $this->db->obtener_data();
        foreach ($prestamos as $key => $value) {
            $datos[] = [
                'idPrestamo' => $value['idPrestamo'],
                'libro'      => [
                    'id'      => $value['idLibro'],
                    'label'   => $value['titulo']
                ],
                'usuario'      => [
                    'id'      => $value['idRegistro'],
                    'label'   => $value['usuario']
                ],
                'fechaPrestamo'       => $value['f'],
                'f'           => $value['fechaPrestamo'],

                'fechaDevolucion'       => $value['d'],
                'd'           => $value['fechaDevolucion']

            ]; 
        }
        return $this->respuesta = $datos;
    }
    public function traer_registro_libro(){
        $this->db->consultas('
            select registros.usuario AS label, registros.idRegistro AS id
            from registros
        ');
        $registros = $this->db->obtener_data();
        $this->db->consultas('
            select libros.libro AS label, libros.idLibro AS id
            from libros
        ');
        $libros = $this->db->obtener_data();
        return $this->respuesta = ['registros'=>$registros, 'libros'=>$libros ];//array de php en v7+
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