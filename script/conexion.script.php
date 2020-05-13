<?php



function retornarConexion() {
  $con=mysqli_connect("localhost","root","CAperez26","centro_salud");
  return $con;
}

function selectAll($table){

  $sql="select * from $table";
  $conn=retornarConexion();
  $registros=mysqli_query($conn,$sql);
    while ($reg=mysqli_fetch_array($registros)){
      $datos[]=$reg;
   }
  return $datos;
}

?>