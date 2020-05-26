<?php

class model{

  function getDoctores($hospítal){

    $sql="select * from doctor where hospital_ID='$hospítal'";
    $conn = connect_db();
    $registros=mysqli_query($conn,$sql);
      while ($reg=mysqli_fetch_array($registros)){
        $datos[]=$reg;
     }
    return $datos;
}

function getPacientes($hospítal){

  $sql="select * from paciente where hospital_ID='$hospítal'";
  $conn = connect_db();
  $registros=mysqli_query($conn,$sql);
    while ($reg=mysqli_fetch_array($registros)){
      $datos[]=$reg;
   }
  return $datos;
}

  function getHospitales(){

        $sql="select * from hospital";
        $conn = connect_db();
        $registros=mysqli_query($conn,$sql);
          while ($reg=mysqli_fetch_array($registros)){
            $datos[]=$reg;
         }
        return $datos;
    }

    function getTriages($hospítal){

      $sql="select * from triage where hospital_ID='$hospítal'";
      $conn = connect_db();
      $registros=mysqli_query($conn,$sql);
        while ($reg=mysqli_fetch_array($registros)){
          $datos[]=$reg;
       }
      return $datos;
  }

    function getHospital($id){

      $sql="select * from hospital where id='$id'";
      $conn = connect_db();
      $registros=mysqli_query($conn,$sql);
      $reg=mysqli_fetch_array($registros);
       
      return $reg;
  }

  function getPaciente($id){

    $sql="select * from paciente where identificacion='$id'";
    $conn = connect_db();
    $registros=mysqli_query($conn,$sql);
    $reg=mysqli_fetch_array($registros);
     
    return $reg;
}

function getDoctor($id){

  $sql="select * from doctor where id='$id'";
  $conn = connect_db();
  $registros=mysqli_query($conn,$sql);
  $reg=mysqli_fetch_array($registros);
   
  return $reg;
}

function getTriage($id){

  $sql="select * from triage where id='$id'";
  $conn = connect_db();
  $registros=mysqli_query($conn,$sql);
  $reg=mysqli_fetch_array($registros);
   
  return $reg;
}







function postHospital($request){
      
      $nombre=$request['nombre'];
      $telefono=$request['telefono'];
      $direccion=$request['direccion'];
      $nit=$request['nit'];
      $representante=$request['representante'];

      $sql="INSERT INTO hospital(nombre, telefono, direccion, nit, representante) 
                  VALUES ('$nombre','$telefono','$direccion','$nit','$representante')";
      $conn = connect_db();
      if(mysqli_query($conn,$sql))
      {
        http_response_code(201);
        $policy = [
          'id'    => mysqli_insert_id($conn),
          'nombre' => $nombre,
          'telefono' => $telefono,
          'direccion' => $direccion,
          'nit' => $nit,
          'representante' => $representante          
        ];
        return json_encode($policy);
      }
      
      var_dump($conn->error);
  }


  
  function postDoctor($request){
      
    $id=$request['id'];
    $nombre=$request['nombre'];
    $direccion=$request['direccion'];
    $telefono=$request['telefono'];
    $tipo_sangre=$request['tipo_sangre'];
    $experiencia=$request['experiencia'];
    $nacimiento=$request['nacimiento'];
    

    $sql="INSERT INTO doctor(hospital_ID, nombre, direccion, telefono, tipo_sangre, experiencia, nacimiento) 
                VALUES ('$id','$nombre','$direccion','$telefono','$tipo_sangre','$experiencia','$nacimiento')";
    $conn = connect_db();
    if(mysqli_query($conn,$sql))
    {
      http_response_code(201);
      $policy = [
        'id'    => $id,
        'nombre' => $nombre,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'tipo_sangre' => $tipo_sangre,
        'experiencia' => $experiencia,
        'nacimiento' => $nacimiento          
      ];
      return json_encode($policy);
    }
    
    var_dump($conn->error);
}

  
function postPaciente($request){
      
  $id=$request['identificacion'];
  $nombre=$request['nombre'];
  $hospital=$request['hospital'];
  $direccion=$request['direccion'];
  $telefono=$request['telefono'];
  $eps=$request['eps'];
  $acompaniante=$request['acompaniante'];
  $antecedentes=$request['antecedentes'];
  

  $sql="INSERT INTO paciente(identificacion, hospital_ID, nombre, eps, direccion, nombre_a, telefono_a, antecedentes) 
              VALUES ('$id','$hospital','$nombre','$eps','$direccion','$acompaniante','$telefono','$antecedentes')";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id,
      'nombre' => $nombre,
      'direccion' => $direccion,
      'telefono' => $telefono,
      'eps' => $eps,
      'acompaniante' => $acompaniante,
      'antecedentes' => $antecedentes          
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

function postTriage($request){
      
  $hospital=$request['hospital'];
  $doctor=$request['doctor'];
  $paciente=$request['paciente'];
  $motivos=$request['motivo'];
  $diagnostico=$request['diagnostico'];
  $medicamentor=$request['medicamentor'];
  $medicamentos=$request['medicinas'];
  $sintoma=$request['sintoma'];
  $covid=$request['covid'];
  

  $sql="INSERT INTO triage(hospital_ID, doctorID, pacienteID, motivos_consulta, diagnostico, req_medicamento, medicamento, sintomas, pos_COVID19) 
              VALUES ('$hospital','$doctor','$paciente','$motivos','$diagnostico','$medicamentor','$medicamentos','$sintoma','$covid')";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => mysqli_insert_id($conn),
      'hospital_ID' => $hospital,
      'doctorID' => $doctor,
      'pacienteID' => $paciente,
      'motivos_consulta' => $motivos,
      'diagnostico' => $diagnostico,
      'req_medicamento' => $medicamentor,  
      'medicamento' => $medicamentos, 
      'sintomas' => $sintoma,     
      'pos_COVID19' => $covid,  
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

function deleteDoctor($id){
      

  $sql="DELETE FROM doctor WHERE id='$id'";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id       
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

function deletePaciente($id){
      

  $sql="DELETE FROM paciente WHERE identificacion='$id'";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id       
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

function deleteTriage($id){
      

  $sql="DELETE FROM triage WHERE id='$id'";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id       
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

function editHospital($request){
  $id=$request['id'];    
  $nombre=$request['nombre'];
  $telefono=$request['telefono'];
  $direccion=$request['direccion'];
  $nit=$request['nit'];
  $representante=$request['representante'];

  $sql="UPDATE hospital
        SET nombre='$nombre', telefono='$telefono', direccion='$direccion', nit='$nit', representante='$representante' 
          WHERE id='$id'";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id,
      'nombre' => $nombre,
      'telefono' => $telefono,
      'direccion' => $direccion,
      'nit' => $nit,
      'representante' => $representante          
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}


function editDoctor($request){
      
  $id=$request['id'];
  $hospital=$request['hospital'];
  $nombre=$request['nombre'];
  $direccion=$request['direccion'];
  $telefono=$request['telefono'];
  $tipo_sangre=$request['tiposangre'];
  $experiencia=$request['experiencia'];
  $nacimiento=$request['nacimiento'];
  

  $sql="UPDATE doctor
  SET nombre='$nombre', direccion='$direccion', telefono='$telefono', tipo_sangre='$tipo_sangre', experiencia='$experiencia', nacimiento='$nacimiento'
  WHERE id='$id'";
  $conn = connect_db();

  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id,
      'nombre' => $nombre,
      'hospital' => $hospital,
      'direccion' => $direccion,
      'telefono' => $telefono,
      'tipo_sangre' => $tipo_sangre,
      'experiencia' => $experiencia,
      'nacimiento' => $nacimiento          
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

function editPaciente($request){
      
  $id=$request['id'];
  $nombre=$request['nombre'];
  $hospital=$request['hospital'];
  $direccion=$request['direccion'];
  $telefono=$request['telefono'];
  $eps=$request['eps'];
  $acompaniante=$request['acompaniante'];
  $antecedentes=$request['antecedentes'];
  

  $sql="UPDATE paciente
  SET nombre='$nombre', eps='$eps', direccion='$direccion', nombre_a='$acompaniante', telefono_a='$telefono', antecedentes='$antecedentes'
  WHERE identificacion='$id'";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id,
      'hospital'    => $hospital,
      'nombre' => $nombre,
      'direccion' => $direccion,
      'telefono' => $telefono,
      'eps' => $eps,
      'acompaniante' => $acompaniante,
      'antecedentes' => $antecedentes          
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

function editTriage($request){
  $id=$request['id'];  
  $hospital=$request['hospital'];
  $doctor=$request['doctor'];
  $paciente=$request['paciente'];
  $motivos=$request['motivos'];
  $diagnostico=$request['diagnostico'];
  $medicamentor=$request['medicamentor'];
  $medicamentos=$request['medicamentos'];
  $sintoma=$request['sintoma'];
  $covid=$request['covid'];
  

  $sql="UPDATE triage
  SET hospital_ID='$hospital', doctorID='$doctor', pacienteID='$paciente', motivos_consulta='$motivos', diagnostico='$diagnostico', req_medicamento='$medicamentor', medicamento='$medicamentos', sintomas='$sintoma', pos_COVID19='$covid'
  WHERE id='$id'";
  $conn = connect_db();
  if(mysqli_query($conn,$sql))
  {
    http_response_code(201);
    $policy = [
      'id'    => $id,
      'hospital_ID' => $hospital,
      'doctorID' => $doctor,
      'pacienteID' => $paciente,
      'motivos_consulta' => $motivos,
      'diagnostico' => $diagnostico,
      'req_medicamento' => $medicamentor,  
      'medicamento' => $medicamentos, 
      'sintomas' => $sintoma,     
      'pos_COVID19' => $covid,  
    ];
    return json_encode($policy);
  }
  
  var_dump($conn->error);
}

}

?>