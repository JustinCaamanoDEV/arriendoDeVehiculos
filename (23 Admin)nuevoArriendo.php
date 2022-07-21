<html>
<head>
    <title>Administrador</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@500;600;700&display=swap" rel="stylesheet">
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
            <div id="txtHora" style="text-align: right; color: white;"></div>
            <?php
            date_default_timezone_set('America/Santiago');
            $fechaHoy = date('d-m-Y');
            ?>
            <!--<td>Fecha: </td>-->
            <div id="txtDate" style="text-align: right; color: white;"><?php echo $fechaHoy; ?>
    <br>
    <center>
    <form method="post" action="">
    <?php error_reporting(0);?> 
    <?php
        if($_POST['btnBuscarRut']=="Buscar Rut"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $rs = mysqli_query($cnn, "select * from empleado where rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                    $datoNom = $row[nombres];
                    $datoApe = $row[apellidos];
                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                } 
        }       

        if($_POST['btnBuscarPat']=="Buscar Patente"){
            include("funciones.php");
            $cnn = Conectar();
            $pat = $_POST['txtPat'];
            $rs = mysqli_query($cnn, "select * from vehiculo where patente='$pat'");
                if($row = mysqli_fetch_array($rs)){
                    $datoMar = $row[marca];
                    $datoMod = $row[modelo];
                    $datoVal = $row[valorArriendo];
                    $datoGar = $row[garantia]; 
                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                } 
        }        
    ?> 
    <table border="0" align="center" style="color: white;">
        <tr>
            <td colspan="4" align="center"><h1>Arriendo De Vehículo</h1></td>
        </tr>
        <tr>
            <td><b>Rut del Cliente: </b></td>
            <td>
                <?php
                    include ("funciones.php");
                    $cnn = Conectar();
                    $sql = "SELECT rut FROM cliente";
                    $result = mysqli_query($cnn,$sql);
                ?>
                    <select name="txtRutC" style="width:160px">
                        <?php while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["rut"].'</option>';
                        }
                        ?>
                    </select> 
            </td>
        <tr>
            <td><b>Rut del Empleado: </b></td>
            <td>
                <?php
                    $sql = "SELECT rut FROM empleado";
                    $result = mysqli_query($cnn,$sql);
                ?>
                    <select name="txtRutE" style="width:160px">
                        <?php while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["rut"].'</option>';
                        }
                        ?>
                    </select> 
            </td>
        </tr>
        <tr>
            <td><b>Patente del Vehículo: </b></td>
            <td>
                <?php
                    $sql = "SELECT patente FROM vehiculo WHERE estado='D'";
                    $result = mysqli_query($cnn,$sql);
                ?>
                    <select name="txtPat" style="width:160px">
                        <?php while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["patente"].'</option>';
                        }
                        ?>
                    </select> 
            </td>
        </tr>
        <tr>
            <td><b>Fecha Inicio: </b></td>
            <td><input type="date" name="txtIni" style="width:160px" value=""></td>
        </tr>
        <tr>
            <td><b>Fecha Fin: </b></td>
            <td><input type="date" name="txtFin" style="width:160px" value=""></td>
        </tr>
        <tr>
            <td><b></b></td>
            <td><input type="submit" name="btnRegistrar" style="width:160px; height:50px;" value="REGISTRAR"></td>
        </tr>
    </table>   
    <?php
        if($_POST['btnRegistrar']=="REGISTRAR"){
            $cli = $_POST['txtRutC'];
            $emp = $_POST['txtRutE'];
            $pat = $_POST['txtPat'];
            $fecAct = date('Y-m-d');
            $ini = $_POST['txtIni'];
            $fin = $_POST['txtFin'];
            $fecha1 = new DateTime($_POST["txtIni"]);
            $fecha2 = new DateTime($_POST["txtFin"]);

            $diffDias = $fecha1->diff($fecha2);

                $rs = mysqli_query($cnn, "select * from vehiculo where patente='$pat'");
                if($row = mysqli_fetch_array($rs)){
                    $datoVal = $row[valorArriendo];
                    $datoGar = $row[garantia];

                    $totalVal = $datoVal * $diffDias->d;
                    $totalGar = $datoGar * $diffDias->d;
                    $totalFin = $totalVal + $totalGar;                   
                }

                    if(empty($cli) || empty($emp) || empty($pat) || empty($fecha1) || empty($fecha2)){
                        ?><script>alert("Los campos obligatorios deben contener datos")</script><?php
                    }else{
                        //Comparar y buscar la llave primaria de la tabla Cliente para insertar
                        $result1 = mysqli_query($cnn,"SELECT rut FROM cliente WHERE rut='$cli'");
                        $rw1 = mysqli_fetch_array($result1);
                        $rutC = $rw1[0];
                        //Fin de Comparar y buscar tabla Cliente
                        //Comparar y buscar la llave primaria de la tabla Cliente para insertar
                        $result2 = mysqli_query($cnn,"SELECT rut FROM empleado WHERE rut='$emp'");
                        $rw2 = mysqli_fetch_array($result2);
                        $rutE = $rw2[0];
                        //Fin de Comparar y buscar tabla Cliente
                        //Comparar y buscar la llave primaria de la tabla Patente para insertar
                        $result3 = mysqli_query($cnn,"SELECT patente FROM vehiculo WHERE patente='$pat'");
                        $rw3 = mysqli_fetch_array($result3);
                        $patente = $rw3[0];
                        //Fin de Comparar y buscar tabla Patente
                        //Comparar y buscar la llave primaria de la tabla Vehiculo para insertar
                        $result4 = mysqli_query($cnn,"SELECT estado FROM vehiculo WHERE patente='$pat'");
                        $rw4 = mysqli_fetch_array($result4);
                        $estado = $rw4[0];
                        //Fin de Comparar y buscar tabla Vehiculo
                        $sql2 = "UPDATE vehiculo SET estado='A' WHERE patente='$patente' and estado='$estado'";
                        $sql = "INSERT INTO arriendo (rutCliente,rutEmpleado,patente,fechaArriendoWeb,fechaInicioArriendo,fechaFinArriendo,total)VALUES ('$rutC','$rutE','$patente','$fecAct','$ini','$fin','$totalFin')";
                        echo "----------------------------------------------------------------------------------------------- <br>";
                        echo "Se ha registrado su Arriendo. <br>";
                        echo "Total de días de arriendo: $diffDias->d <br>";
                        echo "Total a pagar por días de arriendo: $$totalVal <br>";
                        echo "Total a pagar por garantía: $$totalGar <br>";
                        echo "Total final a pagar: $$totalFin <br>";
                        echo "Acerquese al punto de retiro en la fecha $ini para iniciar el Arriendo. <br>";
                        echo "----------------------------------------------------------------------------------------------- <br>";
                        mysqli_query($cnn,$sql2);
                        mysqli_query($cnn,$sql);
                        ?>
                        <script>alert("El Arriendo del vehículo ha sido ingresado Correctamente")</script><?php
                    }
        }  
        ?>          
    </form>  
</body>
</html>