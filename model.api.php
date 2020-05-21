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

    function getHospitales(){

        $sql="select * from hospital";
        $conn = connect_db();
        $registros=mysqli_query($conn,$sql);
          while ($reg=mysqli_fetch_array($registros)){
            $datos[]=$reg;
         }
        return $datos;
    }

    function getTriage($hospítal){

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
  $direccion=$request['direccion'];
  $telefono=$request['telefono'];
  $eps=$request['eps'];
  $acompaniante=$request['acompaniante'];
  $antecedentes=$request['antecedentes'];
  

  $sql="INSERT INTO paciente(identificacion, nombre, eps, direccion, nombre_a, telefono_a, antecedentes) 
              VALUES ('$id','$nombre','$eps','$direccion','$acompaniante','$telefono','$antecedentes')";
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

}

?>