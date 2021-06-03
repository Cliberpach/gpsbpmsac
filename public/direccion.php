<?php
 $servername = "localhost";
 $username = "usuario";
 $password = 'gps12345678';
 $dbname = "gpstracker";
 echo "start";
while(true)
{
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    $query = "select * from historial where direccion is null order by fecha desc";
    foreach($conn->query($query ) as $fila) {
      $data=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$fila['lat'].",".$fila['lng']."&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI"),true);
     
      $direccion= $data['results'][0]['address_components'][1]['long_name']." ".$data['results'][0]['address_components'][0]['long_name'];
      $params = array(
            ':direccion'     => $direccion,
            ':id' => $fila['id']
        );
        $sentencia = "UPDATE historial set direccion=:direccion where id=:id";
        $update = $conn->prepare($sentencia);
        $update->execute($params);
      }
  
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    die();
    }
}
$conn = null;
?>
