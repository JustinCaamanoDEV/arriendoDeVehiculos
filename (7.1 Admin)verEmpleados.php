<html>
<head>
    <title>Administrador</title>
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
            <!--<td>Hora: </td>-->
            <div id="txtHora" style="text-align: right; color: white;"></div>
            <?php
            date_default_timezone_set('America/Santiago');
            $fechaHoy = date('d-m-Y');
            ?>
            <!--<td>Fecha: </td>-->
            <div id="txtDate" style="text-align: right; color: white;"><?php echo $fechaHoy; ?>
    <br>
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <center>
    <h1 style="color: white;"><b>Mostrar Todos Los Empleados</b></h1>
    <td><input type="submit" name="btnBuscar" style="width:180px; height:50px;" value="VER TODOS LOS EMPLEADOS"></td>
    </form> 
    <?php error_reporting(0);
        if($_POST['btnBuscar']=="VER TODOS LOS EMPLEADOS"){
            include("funciones.php");
            $cnn = Conectar();
            $rs = mysqli_query($cnn, "select * from empleado");
                echo "<table align='center' border='5' bordercolor='black' bgcolor='white' style='color: black;'>";
                echo "<tr align='center'>";
                echo "<td><b>RUT</b></td>";
                echo "<td><b>NOMBRES</b></td>";
                echo "<td><b>APELLIDOS</b></td>";
                echo "<td><b>F. NACIMIENTO</b></td>";
                echo "<td><b>SEXO</b></td>";
                echo "<td><b>DIRECCION</b></td>";
                echo "<td><b>REGION</b></td>";
                echo "<td><b>FONO</b></td>";
                echo "<td><b>CORREO</b></td>";
                echo "<td><b>CARGO</b></td>";
                echo "<td><b>USUARIO</b></td>";
                echo "<td><b>CONTRASEÑA</b></td>";
                echo "</tr>";
                    while ($row = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        echo "<td>$row[rut]</td>";
                        echo "<td>$row[nombres]</td>";
                        echo "<td>$row[apellidos]</td>";
                        echo "<td>$row[fechaNac]</td>";
                        echo "<td>$row[sexo]</td>";
                        echo "<td>$row[direccion]</td>";
                        echo "<td>$row[region]</td>";
                        echo "<td>$row[fono]</td>";
                        echo "<td>$row[correo]</td>";
                        echo "<td>$row[cargo]</td>";
                        echo "<td>$row[usuario]</td>";
                        echo "<td>$row[contraseña]</td>";
                    }
                echo "</table>";    
        }
    ?> 
</body>
</html>