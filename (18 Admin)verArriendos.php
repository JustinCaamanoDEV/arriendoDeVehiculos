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
    <h1 style="color: white;"><b>Mostrar Todos Los Arriendos En Curso</b></h1>
    <td><input type="submit" name="btnBuscar" style="width:180px; height:50px;" value="VER TODOS LOS ARRIENDOS"></td>
    </form> 
    <?php 
        if($_POST['btnBuscar']=="VER TODOS LOS ARRIENDOS"){
            include("funciones.php");
            $cnn = Conectar();
            $rs = mysqli_query($cnn, "select * from arriendo");
                echo "<table align='center' border='5' bordercolor='black' bgcolor='white' style='color: black;'>";
                echo "<tr align='center'>";
                echo "<td><b>N°FOLIO</b></td>";
                echo "<td><b>RUT CLIENTE</b></td>";
                echo "<td><b>RUT EMPLEADO</b></td>";
                echo "<td><b>PATENTE VEHICULO</b></td>";
                echo "<td><b>FECHA ARRIENDO WEB</b></td>";
                echo "<td><b>FECHA INICIO</b></td>";
                echo "<td><b>FECHA FIN</b></td>";
                echo "<td><b>TOTAL</b></td>";
                echo "</tr>";
                    while ($row = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        echo "<td>$row[folio]</td>";
                        echo "<td>$row[rutCliente]</td>";
                        echo "<td>$row[rutEmpleado]</td>";
                        echo "<td>$row[patente]</td>";
                        echo "<td>$row[fechaArriendoWeb]</td>";
                        echo "<td>$row[fechaInicioArriendo]</td>";
                        echo "<td>$row[fechaFinArriendo]</td>";
                        echo "<td>$row[total]</td>";
                    }
                echo "</table>";    
        }
    ?> 
</body>
</html>