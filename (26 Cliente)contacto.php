<html>
  <head>
    <title>Contacto</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
    function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            // add a zero in front of numbers<10
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById("txtHora").innerHTML = h + ":" + m + ":" + s;
            var t = setTimeout(function(){ startTime() }, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    </script>
</head>
<body onload="startTime()">
<?php error_reporting(0);?> 
            <!--<td>Hora: </td>-->
            <div id="txtHora" style="text-align: right; color: white;"></div>
            <?php
            date_default_timezone_set('America/Santiago');
            $fechaHoy = date('d-m-Y');
            ?>
            <!--<td>Fecha: </td>-->
            <div id="txtDate" style="text-align: right; color: white;"><?php echo $fechaHoy; ?>
    <br><br>
    <center> 
    <form name="form1" method="post">    
    <h1 style="color: white;"><b>Contacto</b></h1>     
    <table style="color: white;">
        <tr>
            <td>Ingrese su usuario: </td>
            <td><input type="text" name="txtUsu" size="34px" value=""></td>
        </tr> 
        <tr>
            <td>Deje sus comentarios: </td>
            <td><textarea name="cajaComentarios" rows="10" cols="34" display="center" placeholder="Escriba aquí sus comentarios (Máximo 300 palabras)"></textarea><br></td>
        </tr>   
        <tr>
            <td></td>
            <td><input type="submit" name="btnEnviar" id="btnEnviar" style="width:257px; height:50px;" value="ENVIAR"></td>
        </tr>
    </table>    
    <?php
        if($_POST['btnEnviar']=="ENVIAR"){
            include ("funciones.php");
            $cnn = Conectar();
            $usu = $_POST['txtUsu'];
            $com = $_POST['cajaComentarios'];
            if(empty($usu) || empty($com)){
                ?><script>alert("Los campos deben contener datos")</script><?php
            }else{    
            $sql = "INSERT INTO comentarios (usuario,comentario) VALUES ('$usu','$com')";
            mysqli_query($cnn,$sql);
            ?>
            <script>alert("Gracias por enviar su comentario!")</script><?php
            }
        }
    ?>
    </form>
  </body>
</html>
    