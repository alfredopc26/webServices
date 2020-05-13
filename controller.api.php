<?php
require "script/conexion.script.php";
require "model.api.php";

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: *");

class controller{


    function getPacientes(){

        // $model=new model();

        return selectAll('paciente');

    }

    function getHospitales(){

        // $model=new model();

        return selectAll('hospital');

    }

    function getDoctores($hospital){

        $model=new model();

        return $model->getDoctores($hospital);

    }

    function postHospital($request){

        $model=new model();

        return $model->postHospital($request);
    }


}


$option=$_GET['option'];
$class=new controller();
$postdata = file_get_contents("php://input");
switch($option){


//   Bloque GET para obtener la info solicitada  
    case "getPacientes":

        $datos=$class->getPacientes();
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        $file=file_put_contents("allPacientes.json", $prepFile);
        echo $prepFile;
    break;

    case "getHospitales":

        $datos=$class->getHospitales();
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        $file=file_put_contents("allHospital.json", $prepFile);
        echo $prepFile;
    break;

    case "getDoctores":
        $hospital=$_GET['hospital'];
        $datos=$class->getDoctores($hospital);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        $file=file_put_contents("allPDoctores.json", $prepFile);
    break;

// Bloque POST para realizar los insert correspondientes
    
    case "insertHospital":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata);

        }else{
          http_response_code(422);
        
        }


    break;

}

?>