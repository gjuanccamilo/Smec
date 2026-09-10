<html>
  
	<head>
		<style>
      body{
        background-color: #ABEBC6;
        font-family: century;
        font-size: 14;
      }
			table {
        border-collapse: collapse;
        font-family: century;
        font-size: 11;
      }

      td {
          border: 3px solid #589B99;
          padding: 0.5rem;
          text-align: left;
        }
      th {
          border: 3px solid #589B99;
          padding: 0.5rem;
          text-align: left;
          background-color:chartreuse ;
           }
        tr:hover {background-color: coral;}
        .buscar{
          height: 25px;
          width:  200px;
          padding-top: 0px;
          padding-bottom: 0px;
          display: flex;
          flex-direction: row;
          justify-content: space-between;
          
        }
        .buscar1{
          padding-top: 10px;
          padding-bottom: 0px;
          
        }
        .buscar2{
          padding-top: 0px;
          padding-bottom: 0px;

        }
		</style>
    
	</head>
  
    <body>

    


        <form id="forma" name="forma" action="index4.php">

        <h1>ADMINISTRADOR</h1>
        <br>
        
        
                  
        <br>
        <?php
        session_start();
       
      try {
          //Interfaz de conexion
          $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
          
      } catch (PDOException $e) {
          //Casa de que ocurra algun error
          echo "Fallo la conexion ".$e->getMessage();
      }
      
      // Consulta SELECT
    $consulta = "SELECT a.identificacion, a.nombres, a.tipo_persona, b.descripcion FROM persona a, tipo_persona b where a.tipo_persona = a.tipo_persona and a.identificacion='".$_SESSION['id']."';";
    //$consulta = "SELECT a.id_persona, a.nombre, a.tipo_persona, b.descripcion FROM persona a, tipo_persona b where a.tipo_persona = b.tipo_persona and a.id_persona='01';";
  
      // Preparar la consulta
      $row = $conexion -> prepare($consulta);
  
      // Ejecutar la consulta
      $row->execute();
              // Obtener los resultados en un array asociativo
      $resultados = $row->fetchAll(PDO::FETCH_ASSOC);

      foreach ($resultados as $fila) {
        echo "BIENVENIDO ADMIN   ".$_SESSION['usuario']." Usted es: ".$fila['descripcion'];
      }
     
        ?>
        </form>

        <input type="button" onclick="location.href='usuypass2.php'" value="Volver al Login">
        <input type="button" onclick="location.href='cerrar.php'" value="Cerrar Sesion">
        <input type="button" onclick="location.href='MA_registrese.php'" value="Registrarse">
    </body>
</html>



