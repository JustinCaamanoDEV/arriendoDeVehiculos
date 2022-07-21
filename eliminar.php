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
    <br><br>
    <center>
    <h1><b>Eliminar Clientes</b></h1>
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <?php 
        if($_POST['btnBuscar']=="Buscar"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $rs = mysqli_query($cnn, "select * from clientes where rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                    $datoNom = $row[nombres];
                    $datoApe = $row[apellidos];
                    echo $daroNom;
                }else{
                    echo "<script>alert('Rut no Existe')</script>";
                }
        }
    ?>
    <table border="0">
        <tr>
            <td><b>Rut: </b></td>
            <td><input type="text" name="txtRut" value="<?php echo $rut;?>"></td>
            <td><input type="submit" name="btnBuscar" value="Buscar"></td>
        </tr>
        <tr>
            <td><b>Nombres: </b></td>
            <td><input type="text" name="txtNom" value="<?php echo $datoNom;?>"></td>
        </tr>
        <tr>
            <td><b>Apellidos: </b></td>
            <td><input type="text" name="txtApe" value="<?php echo $datoApe;?>"></td>
        </tr>
        <tr>
            <td colspan="4" align="center"><input type="submit" name="btnEliminar" value="Eliminar"></td>
         </tr>
    </table>  
    <?php 
        if($_POST['btnEliminar']=="Eliminar"){
            include("funciones.php");
            $cnn = Conectar();
            $rut = $_POST['txtRut'];
            $sql = "delete from clientes where rut = '$rut'";
            mysqli_query($cnn, $sql);
            echo "<script>alert('Se ha Eliminado el Registro')</script>";
        }
    ?>
    

    </form>  
</body>
</html>