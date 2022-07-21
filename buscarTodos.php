<html>
<head>
    <title>Mantenedor de Datos</title>
    <script>    
        function ValidaSoloNumeros(){
            if((event.keyCode < 48) || (event.keyCode > 57))
                event.returnValue = false;   
        }
        function ValidaSoloLetras(){
            if((event.keyCode != 32) && (event.keyCode < 65) ||
                (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
                event.returnValue = false;   
        }

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
            <div id="txtHora" style="text-align: right;"></div>
            <?php
            date_default_timezone_set('America/Santiago');
            $fechaHoy = date('d-m-Y');
            ?>
            <!--<td>Fecha: </td>-->
            <div id="txtDate" style="text-align: right;"><?php echo $fechaHoy; ?>
    <br>
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <center>
    <h1><b>Mostrar Todos Los Clientes</b></h1>
    <td><input type="submit" name="btnBuscar" value="Visualizar a Todos"></td>
    </form> 
    <?php 
        if($_POST['btnBuscar']=="Visualizar a Todos"){
            include("funciones.php");
            $cnn = Conectar();
            $rs = mysqli_query($cnn, "select * from clientes");
                echo "<table align='center' border='1'>";
                echo "<tr align='center'>";
                echo "<td><b>RUT</b></td>";
                echo "<td><b>NOMBRES</b></td>";
                echo "<td><b>APELLIDOS</b></td>";
                echo "<td><b>F. NACIMIENTO</b></td>";
                echo "<td><b>SEXO</b></td>";
                echo "<td><b>REGION</b></td>";
                echo "<td><b>FONO</b></td>";
                echo "</tr>";
                    while ($row = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        echo "<td>$row[rut]</td>";
                        echo "<td>$row[nombres]</td>";
                        echo "<td>$row[apellidos]</td>";
                        echo "<td>$row[fechaNacimiento]</td>";
                        echo "<td>$row[sexo]</td>";
                        echo "<td>$row[region]</td>";
                        echo "<td>$row[fono]</td>";
                    }
                echo "</table>";    
        }
    ?> 
</body>
</html>