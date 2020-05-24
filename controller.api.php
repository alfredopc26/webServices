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
                    "hospital"=>$q['hospital_ID'],
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

    function getPaciente($paciente){

        $model=new model();

        $q=$model->getPaciente($paciente);

        $datos=array(
            "id"=>$q['identificacion'],
            "hospital"=>$q['hospital_ID'],
            "nombre"=>$q['nombre'],
            "eps"=>$q['eps'],
            "telefono"=>$q['telefono_a'],
            "direccion"=>$q['direccion'],
            "acompaniante"=>$q['nombre_a'],
            "antecedentes"=>$q['antecedentes']
        );
           
        

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

    function getDoctor($doctor){

        $model=new model();

        $q= $model->getDoctor($doctor);

        $datos=array(
            "id"=>$q['id'],
            "hospital"=>$q['hospital_ID'],
            "nombre"=>$q['nombre'],
            "direccion"=>$q['direccion'],
            "telefono"=>$q['telefono'],
            "tiposangre"=>$q['tipo_sangre'],
            "experiencia"=>$q['experiencia'],
            "nacimiento"=>$q['nacimiento']
        );
        

        return $datos;

    }

    function getTriages($hospital){

        $model=new model();
        $query= $model->getTriages($hospital);

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

    function getTriage($triage){

        $model=new model();
        $q= $model->getTriage($triage);

        $datosDoctor=$model->getDoctor($q['doctorID']);
        $datosPaciente=$model->getPaciente($q['pacienteID']);
        $sintomas=explode(",",$q['sintomas']);
        $dolor_garganta=false;
        $tos=false;
        $fiebre=false;
        $congestion=false;
        $fatiga=false;

        foreach($sintomas as $s){
          
            if($s=="Dolor de Garganta"){
                $dolor_garganta=true;
            }
            if($s=="Fiebre"){
                $fiebre=true;               
            }
            if($s=="Tos"){
                $tos=true;
            }
            if($s=="Fatiga Muscular"){
                $fatiga=true;
            }
            if($s=="Congestion"){
                $congestion=true;
            }

        }

        if($q['req_medicamento']=="Y"){
            $medicamento=true;
        }else{
            $medicamento=false;
        }

            $datos=array(
                "id"=>$q['id'],
                "hospital"=>$q['hospital_ID'],
                "doctor"=>$datosDoctor['id'],
                "paciente"=>$datosPaciente['identificacion'],
                "motivos"=>$q['motivos_consulta'],
                "diagnostico"=>$q['diagnostico'],
                "medicamentoR"=>$medicamento,
                "medicamentos"=>$q['medicamento'],
                "dolor_garganta"=>$dolor_garganta,
                "tos"=>$tos,
                "fiebre"=>$fiebre,
                "congestion"=>$congestion,
                "fatiga"=>$fatiga
            );

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
    case "getPaciente":
        $paciente=$_GET['paciente'];
        $datos=$class->getPaciente($paciente);
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

    case "getDoctor":
        $doctor=$_GET['doctor'];
        $datos=$class->getDoctor($doctor);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        echo $prepFile;
    break;

    case "getTriages":
        $hospital=$_GET['hospital'];
        $datos=$class->getTriages($hospital);
        $prepFile=json_encode($datos, JSON_PRETTY_PRINT);
        echo $prepFile;
    break;

    case "getTriage":
        $hospital=$_GET['triage'];
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
                $sintoma=$sintoma."congestion";
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

    // Seccion de editar

    case "editDoctor":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata, true);
          $model=new model();
        //   var_dump($request);
         echo $model->editDoctor($request);
            
        }else{
          http_response_code(422);
        
        }
    break;

    case "editPaciente":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata, true);
          $model=new model();
        //   var_dump($request);
         echo $model->editPaciente($request);
            
        }else{
          http_response_code(422);
        
        }
    break;

    case "editTriage":
        if(isset($postdata) && !empty($postdata))
        {
          // Extraer los datos
          $request = json_decode($postdata, true);
            $sumVal=0;
            $sintoma="";
            if($request['medicamentoR']){
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
                $sintoma=$sintoma."congestion";
                $sumVal++;
            }

            if($sumVal>=2){
                $request['covid']='Y';
            }else{
                $request['covid']='N';
            }
            $request['sintoma']=$sintoma;

          $model=new model();
         echo $insertDatos=$model->editTriage($request);
            
        }else{
          http_response_code(422);
        
        }


    break;

}

?>