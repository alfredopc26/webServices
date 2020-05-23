<?php
require "script/conexion.script.php";
require "model.api.php";



header("Access-Control-Allow-Origin: http://192.168.39.102:4200");
header("Access-Control-Allow-Headers: *");

class controller{


    function getPacientesHospital($hospital){

        $model=new model();

        $query=$model->getPacientes($hospital);
        foreach($query as $q){

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

        $model=new model();
        $query=$model->getHospitales('hospital');

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
                "id"=>$q['id'],
                "hospital"=>$q['hospital_ID'],
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

    function getTriage($hospital){

        $model=new model();
        $query= $model->getTriage($hospital);

        foreach($query as $q){

            $datosDoctor=$model->getDoctor($q['doctorID']);
            $datosPaciente=$model->getPaciente($q['pacienteID']);

            $datos[]=array(
                "id"=>$q['id'],
                "hospital"=>$q['hospital_ID'],
                "doctor"=>array('id'=>$datosDoctor['id'], 'nombre'=>$datosDoctor['nombre']),
                "paciente"=>array('id'=>$datosPaciente['identificacion'], 'nombre'=>$datosPaciente['nombre']),
                "motivos"=>$q['motivos_consulta'],
                "diagnostico"=>$q['diagnostico'],
                "medicamentoR"=>$q['req_medicamento'],
                "medicamentos"=>$q['medicamento'],
                "sintomas"=>$q['sintomas'],
                "covid"=>$q['pos_COVID19']
            );
        }

        return $datos;

    }

    function newHospital($request){

        $model=new model();

        return $model->postHospital($request);
    }

    function newDoctor($request){

        $model=new model();

        return $model->postDoctor($request);
    }
    function newPaciente($request){

        $model=new model();

        return $model->postPaciente($request);
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
        echo $prepFile;
    break;

    case "getHospitales":

        $datos=$class->getHospitales();
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        echo $prepFile;
    break;

    case "getHospital":
        $hospital=$_GET['hospital'];
        $datos=$class->getHospital($hospital);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        echo $prepFile;
    break;

    case "getDoctores":
        $hospital=$_GET['hospital'];
        $datos=$class->getDoctores($hospital);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        echo $prepFile;
    break;

    case "getTriage":
        $hospital=$_GET['hospital'];
        $datos=$class->getTriage($hospital);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        echo $prepFile;
    break;
// Bloque POST para realizar los insert correspondientes
    
    case "insertHospital":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata, true);

        //   var_dump($request);
         echo $insertDatos=$class->newHospital($request);
            
        }else{
          http_response_code(422);
        
        }


    break;

    case "insertDoctor":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata, true);

        //   var_dump($request);
         echo $insertDatos=$class->newDoctor($request);
            
        }else{
          http_response_code(422);
        
        }


    break;

    case "insertPaciente":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata, true);

        //   var_dump($request);
         echo $insertDatos=$class->newPaciente($request);
            
        }else{
          http_response_code(422);
        
        }


    break;

    case "insertTriage":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata, true);
            $sumVal=0;
            $sintoma="";
            if($request['medicamentor']){
                $request['medicamentor']='Y';
            }else{
                $request['medicamentor']='N';
            }

            if($request['dolor_garganta']){
                $sintoma=$sintoma."Dolor de Garganta,";
                $sumVal++;
            }
            if($request['fiebre']){
                $sintoma=$sintoma."Fiebre,";
                $sumVal++;                
            }
            if($request['tos']){
                $sintoma=$sintoma."Tos,"; 
                $sumVal++;
            }
            if($request['fatiga']){
                $sintoma=$sintoma."Fatiga Muscular,";
                $sumVal++;
            }
            if($request['congestion']){
                $sintoma=$sintoma."Congestoion";
                $sumVal++;
            }

            if($sumVal>=2){
                $request['covid']='Y';
            }else{
                $request['covid']='N';
            }
            $request['sintoma']=$sintoma;

          $model=new model();
         echo $insertDatos=$model->postTriage($request);
            
        }else{
          http_response_code(422);
        
        }


    break;


    // Bloque para realizar los DELETE correspondientes

    case "borrarDoctor":
        $model=new model();
        $doctor=$_GET['id'];
        $datos=$model->deleteDoctor($doctor);
        
        echo $datos;

    break;

    case "borrarPaciente":
        $model=new model();
        $doctor=$_GET['id'];
        $datos=$model->deletePaciente($doctor);
        
        echo $datos;

    break;

    case "borrarTriage":
        $model=new model();
        $doctor=$_GET['id'];
        $datos=$model->deleteTriage($doctor);
        
        echo $datos;

    break;


}

?>