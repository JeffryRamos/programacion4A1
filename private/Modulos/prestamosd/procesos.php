<?php 
include('../../Config/Config.php');
$prestamod = new prestamod($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$prestamod->$proceso( $_GET['prestamod'] );
print_r(json_encode($prestamod->respuesta));

class prestamod{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($prestamod){
        $this->datos = json_decode($prestamod, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['docente']['id']) ){
            $this->respuesta['msg'] = 'Por favor ingrese el docente del prestamo';
        }
        if( empty($this->datos['libro']['id']) ){
            $this->respuesta['msg'] = 'Por favor ingrese el libro';
        }
        if( empty($this->datos['fechaPrestamo']) ){
            $this->respuesta['msg'] = 'Por favor ingrese la fecha';
        }
        $this->almacenar_prestamod();
    }
    private function almacenar_prestamod(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO prestamosd (idDocente,idLibro,fechaPrestamo,fechaDevolucion) VALUES(
                        "'. $this->datos['docente']['id'] .'",
                        "'. $this->datos['libro']['id'] .'",
                        "'. $this->datos['fechaPrestamo'] .'",
                        "'. $this->datos['fechaDevolucion'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE prestamosd SET
                        idDocente     = "'. $this->datos['docente']['id'] .'",
                        idLibro      = "'. $this->datos['libro']['id'] .'",
                        fechaPrestamo         = "'. $this->datos['fechaPrestamo'] .'",
                        fechaDevolucion         = "'. $this->datos['fechaDevolucion'] .'"
                    WHERE idPrestamod = "'. $this->datos['idPrestamod'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            }
        }
    }
    public function buscarPrestamod($valor = ''){
        if( substr_count($valor, '-')===2 ){
            $valor = implode('-', array_reverse(explode('-',$valor)));
        }
        $this->db->consultas('
            select prestamosd.idPrestamod, prestamosd.idDocente, prestamosd.idLibro, 
                date_format(prestamosd.fechaPrestamo,"%d-%m-%Y") AS fechaPrestamo, prestamosd.fechaPrestamo AS f,
                date_format(prestamosd.fechaDevolucion,"%d-%m-%Y") AS fechaDevolucion, prestamosd.fechaDevolucion AS d,
                libros.codigo, libros.titulo, 
                docentes.codigo, docentes.nombre

            from prestamosd
                inner join libros on(libros.idLibro=prestamosd.idLibro)
                inner join docentes on(docentes.idDocente=prestamosd.idDocente)

            where libros.titulo like "%'. $valor .'%" or docentes.nombre like "%'. $valor .'%" or prestamosd.fechaPrestamo like "%'. $valor .'%" or prestamosd.fechaDevolucion like "%'. $valor .'%"

        ');
        $prestamosd = $this->respuesta = $this->db->obtener_data();
        foreach ($prestamosd as $key => $value) {
            $datos[] = [
                'idPrestamod' => $value['idPrestamod'],
                'libro'      => [
                    'id'      => $value['idLibro'],
                    'label'   => $value['titulo']
                ],
                'docente'      => [
                    'id'      => $value['idDocente'],
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
    public function traer_docente_libro(){
        $this->db->consultas('
            select docentes.nombre AS label, docentes.idDocente AS id
            from docentes
        ');
        $docentes = $this->db->obtener_data();
        $this->db->consultas('
            select libros.libro AS label, libros.idLibro AS id
            from libros
        ');
        $libros = $this->db->obtener_data();
        return $this->respuesta = ['docentes'=>$docentes, 'libros'=>$libros ];//array de php en v7+
    }
    public function eliminarPrestamod($idPrestamod = 0){
        $this->db->consultas('
            DELETE prestamosd
            FROM prestamosd
            WHERE prestamosd.idPrestamod="'.$idPrestamod.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>