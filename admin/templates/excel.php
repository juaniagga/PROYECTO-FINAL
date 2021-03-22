<?php 

if(isset($_POST["export_data"])) {
    $filename = "planilla_".date('Ymd') . ".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=" . $filename);
    $mostrar_columnas = false;

    $sql = "SELECT * FROM inscrtiptos";
    $resultado = mysqli_query ($conexion, $sql) or die (mysql_error ());

    $inscriptos = array();

    while( $rows = mysqli_fetch_assoc($resultado) ) {

        $inscriptos[] = $rows;

    }

    if(!empty($inscriptos)) {
        foreach($inscriptos as $inscripto) {

            if(!$mostrar_columnas) {

            echo implode(“\t”, array_keys($inscripto)) . “\n”;

            $mostrar_columnas = true;

            }

            echo implode(“\t”, array_values($inscripto)) . “\n”;

        }
    }else{

        echo ‘No hay datos a exportar’;

    }

    exit;

    }

//otra version
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=" . $filename);
?>

<!-- ACA va el html -->

<?php 
try {
    include_once 'funciones/funciones.php';
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }

$id_evento= $_SESSION['id_evento'];

//if(isset($_POST["export_data"])) {
    $filename = "planilla_".date('Ymd') . ".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=" . $filename);
    $mostrar_columnas = false;

    $resultado = $db->query("SELECT * FROM participante p WHERE p.id_evento=" . $id_evento);

    $inscriptos = array();

    while( $roww = mysqli_fetch_assoc($resultado) ) {
        $inscriptos[] = $roww;
    }

    if(!empty($inscriptos)) {
        foreach($inscriptos as $inscripto) {

            if(!$mostrar_columnas) {

            echo implode("\t", array_keys($inscripto)) . "\n";

            $mostrar_columnas = true;

            }

            echo implode("\t", array_values($inscripto)) . "\n";

        }
    }else{
        echo "No hay datos a exportar";
    }

    exit;

//} if

//otra version
/* $filename = "planilla.xls";
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=" . $filename);

    $mostrar_columnas = false;

    $resultado = $db->query("SELECT * FROM participante p WHERE p.id_evento=" . $id_evento);

    $inscriptos = array();

    while( $row = mysqli_fetch_assoc($resultado) ) {
        $inscriptos[] = $row;
    }

    if(!empty($inscriptos)) {
        foreach($inscriptos as $inscripto) {

            if(!$mostrar_columnas) {

            echo implode("\t", array_keys($inscripto)) . "\n";

            $mostrar_columnas = true;

            }

            echo implode("\t", array_values($inscripto)) . "\n";

        }
    }else{
        echo "No hay datos a exportar";
    }

    exit; */

?>

<!-- ACA va el html -->