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
        if($_POST['btnBuscar']=="Buscar"){
            include("funciones.php");
            $cnn = Conectar();
            $fol = $_POST['txtFol'];
            $rs = mysqli_query($cnn, "select * from arriendo where folio='$fol'");
                if($row = mysqli_fetch_array($rs)){
                    $datoRutC = $row[rutCliente];
                    $datoRutE = $row[rutEmpleado];
                    $datoPat = $row[patente];
                    $datoIni = $row[fechaInicioArriendo]; 
                    $datoFin = $row[fechaFinArriendo];
                    $datoTot = $row[total]; 
                }else{
                    echo "<script>alert('Ingrese N° Folio valido.')</script>";
                } 
        }        
    ?> 
    <table border="0" align="center" style="color: white;">
        <tr>
            <td colspan="4" align="center"><h1>Finalizar Arriendo</h1></td>
        </tr>
        <tr>
            <td><b>N° Folio: </b></td>
            <td><input type="text" name="txtFol" value="<?php echo $fol;?>"></td>
            <td><input type="submit" name="btnBuscar" value="Buscar"></td>
        </tr>
        <tr>
            <td><b>Rut del Cliente: </b></td>
            <td><input type="text" name="txtRutC" value="<?php echo $datoRutC;?>"></td> 
        <tr>
            <td><b>Rut del Empleado: </b></td>
            <td><input type="text" name="txtRutE" value="<?php echo $datoRutE;?>"></td>
        </tr>
        <tr>
            <td><b>Patente del Vehículo: </b></td>
            <td><input type="text" name="txtPat" value="<?php echo $datoPat;?>"></td>
        </tr>
        <tr>
            <td><b>Fecha Inicio: </b></td>
            <td><input type="text" name="txtIni" value="<?php echo $datoIni;?>"></td>
        </tr>
        <tr>
            <td><b>Fecha Fin: </b></td>
            <td><input type="text" name="txtFin" value="<?php echo $datoFin;?>"></td>
        </tr>
        <tr>
            <td><b>Total: </b></td>
            <td><input type="text" name="txtTot" value="<?php echo $datoTot;?>"></td>
        </tr>
        <tr>
            <td><b></b></td>
            <td><input type="submit" name="btnFinalizar" style="width:160px; height:50px;" value="FINALIZAR"></td>
        </tr>
    </table>   
    <?php
        if($_POST['btnFinalizar']=="FINALIZAR"){
            include("funciones.php");
            $cnn = Conectar();
            $fol = $_POST['txtFol'];
            $pat = $_POST['txtPat'];
            $rs = mysqli_query($cnn, "select * from arriendo where folio='$fol'");
                if($row = mysqli_fetch_array($rs)){
                    $datoFolio = $row[folio];
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
                    $sql2 = "UPDATE vehiculo SET estado='D' WHERE patente='$patente' and estado='$estado'";
                    $sql = "DELETE FROM arriendo WHERE folio='$datoFolio'";
                    mysqli_query($cnn, $sql2);
                    mysqli_query($cnn, $sql);
                    echo "<script>alert('Se ha finalizado el arriendo del vehículo.')</script>";
            }  else{
                echo "ERROR";
            } 
    }    
        ?>          
    </form>  
</body>
</html>