<?php
require "script/conexion.script.php";
require "model.api.php";

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Origin: http://192.168.39.102:4200");
header("Access-Control-Allow-Headers: *");

class controller{


    function getPacientesHospital($hospital){

        $model=new model();

        $query=$model->getTriage($hospital);
        foreach($query as $t){
            $q= $model->getPaciente($t['pacienteID']);
                $datos[]=array(
                    "id"=>$q['identificacion'],
                    "nombre"=>$q['nombre'],
                    "eps"=>$q['eps'],
                    "telefono"=>$q['telefono_a'],
                    "direccion"=>$q['direccion'],
                    "acompaniante"=>$q['nombre_a'],
                    "antecedentes"=>$q['antecedentes']
                );
           
        }


       

        return $datos;
    }

    function getHospitales(){

        $query=selectAll('hospital');

        foreach($query as $q){
            $datos[]=array(
                "id"=>$q['id'],
                "nombre"=>$q['nombre'],
                "telefono"=>$q['telefono'],
                "direccion"=>$q['direccion'],
                "nit"=>$q['nit'],
                "representante"=>$q['representante']
            );
        }

        return $datos;
    }

    function getHospital($id){

        $model=new model();

        $q=$model->getHospital($id);

            $datos=array(
                "id"=>$q['id'],
                "nombre"=>$q['nombre'],
                "telefono"=>$q['telefono'],
                "direccion"=>$q['direccion'],
                "nit"=>$q['nit'],
                "representante"=>$q['representante']
            );
        

        return $datos;
    }

    function getDoctores($hospital){

        $model=new model();

        $query= $model->getDoctores($hospital);

        foreach($query as $q){
            $datos[]=array(
                "id"=>$q['hospital_ID'],
                "nombre"=>$q['nombre'],
                "direccion"=>$q['direccion'],
                "telefono"=>$q['telefono'],
                "tiposangre"=>$q['tipo_sangre'],
                "experiencia"=>$q['experiencia'],
                "nacimiento"=>$q['nacimiento']
            );
        }

        return $datos;

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
        $hospital=$_GET['hospital'];
        $datos=$class->getPacientesHospital($hospital);
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

    case "getHospital":
        $hospital=$_GET['hospital'];
        $datos=$class->getHospital($hospital);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        $file=file_put_contents("allHospital.json", $prepFile);
        echo $prepFile;
    break;

    case "getDoctores":
        $hospital=$_GET['hospital'];
        $datos=$class->getDoctores($hospital);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        $file=file_put_contents("allPDoctores.json", $prepFile);
        echo $prepFile;
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