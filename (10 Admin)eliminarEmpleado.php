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
    <br><br>
    <center>
    <h1><b>Eliminar Empleado</b></h1>
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <?php 
        if($_POST['btnBuscar']=="Buscar"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $rs = mysqli_query($cnn, "select * from empleado where rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                    $datoNom = $row[nombres];
                    $datoApe = $row[apellidos];
                    $datoUsu = $row[usuario];
                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                }
        }
    ?>
    <table border="0" style="color: white;">
        <tr>
            <td><b>Rut: </b></td>
            <td><input type="text" name="txtRut" value="<?php echo $rut;?>"></td>
            <td><input type="submit" name="btnBuscar" value="Buscar"></td>
        </tr>
        <tr>
            <td><b>Nombres: </b></td>
            <td><input type="text" name="txtNom" value="<?php echo $datoNom;?>" readonly></td>
        </tr>
        <tr>
            <td><b>Apellidos: </b></td>
            <td><input type="text" name="txtApe" value="<?php echo $datoApe;?>" readonly></td>
        </tr>
        <tr>
            <td><b>Usuario: </b></td>
            <td><input type="text" name="txtUsu" value="<?php echo $datoUsu;?>" readonly></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="btnEliminar" style="width:160px; height:50px;" value="ELIMINAR"></td>
         </tr>
    </table>  
    <?php 
        if($_POST['btnEliminar']=="ELIMINAR"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $sql = "delete from empleado where rut = '$rut'";
            mysqli_query($cnn, $sql);
            echo "<script>alert('Se ha Eliminado el Registro')</script>";
        }
    ?>
    

    </form>  
</body>
</html>