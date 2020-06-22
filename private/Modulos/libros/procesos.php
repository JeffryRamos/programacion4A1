<?php 
include('../../Config/Config.php');
$libro = new libro($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$libro->$proceso( $_GET['libro'] );
print_r(json_encode($libro->respuesta));
/**
 * @class libro
 */
class libro{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    /**
     * @function recibirDatos recibe los datos del libro
     * $libro representa los datos en si
     */
    public function recibirDatos($libro){
        $this->datos = json_decode($libro, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty(trim($this->datos['codigo'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el codigo del libro'; /**Validacion de datos que conlleva el libro**/
        }
        if( empty(trim($this->datos['titulo'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el titulo del libro'; /**Validacion de datos que conlleva el libro**/
        }
        if( empty( trim($this->datos['edicion'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese la edicion del libro'; /**Validacion de datos que conlleva el libro**/
        }
        $this->almacenar_libro();
    }
    /**Validacion de datos con la BD**/
    private function almacenar_libro(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO libros (codigo,titulo,edicion,genero) VALUES( 
                        "'. $this->datos['codigo'] .'",
                        "'. $this->datos['titulo'] .'",
                        "'. $this->datos['edicion'] .'",
                        "'. $this->datos['genero'] .'"
                    )
                ');
                /**Modificacion y validacion de los datos que estan en la BD**/
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE libros SET
                        codigo     = "'. $this->datos['codigo'] .'",
                        titulo     = "'. $this->datos['titulo'] .'",
                        edicion  = "'. $this->datos['edicion'] .'",
                        genero   = "'. $this->datos['genero'] .'"
                    WHERE idLibro = "'. $this->datos['idLibro'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            } else{
                $this->respuesta['msg'] = 'Error, no se envio la accion a realizar';
            }
        }
    }
    /**Busqueda de libros**/
    public function buscarLibro($valor = ''){
        $this->db->consultas('
            select libros.idLibro, libros.codigo, libros.titulo, libros.edicion, libros.genero
            from libros
            where libros.codigo like "%'. $valor .'%" or libros.titulo like "%'. $valor .'%" or libros.edicion like "%'. $valor .'%"

        ');
        return $this->respuesta = $this->db->obtener_data();
    }
    /**Eliminacion de libros**/
    public function eliminarLibro($idLibro = 0){
        $this->db->consultas('
            DELETE libros
            FROM libros
            WHERE libros.idLibro="'.$idLibro.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>