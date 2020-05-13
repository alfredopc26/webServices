<?php

class model{

    function getDoctores($hospítal){

        $sql="select * from doctor where hospital_ID='$hospítal'";
        $conn=retornarConexion();
        $registros=mysqli_query($conn,$sql);
          while ($reg=mysqli_fetch_array($registros)){
            $datos[]=$reg;
         }
        return $datos;
    }


    function postHospital($request){

      $nombre=$request->nombre;
      $telefono=$request->telefono;
      $direccion=$request->direccion;
      $nit=$request->nit;
      $representate=$request->representante;

      $sql="INSERT INTO hospital('nombre', 'telefono', 'direccion', 'nit', 'representante') 
                  VALUES ({$nombre},{$telefono},{$direccion},{$nit},{$representate})";
      $conn=retornarConexion();
      if(mysqli_query($conn,$sql))
      {
        http_response_code(201);
        $policy = [
          'id'    => mysqli_insert_id($conn),
          'nombre' => $nombre,
          'telefono' => $telefono,
          'direccion' => $direccion,
          'nit' => $nit,
          'representante' => $representate          
        ];
        return json_encode($policy);
      }
  }


}

?>