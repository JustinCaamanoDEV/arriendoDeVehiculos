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
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <table border="0" align="center" style="color: white;">
        <tr>
            <td colspan="4" align="center"><h1>Registro de Vehículo</h1></td>
        </tr>
        <tr>
            <td><b>Patente: </b></td>
            <td><input type="text" name="txtPat" value=""></td>
        </tr>
        <tr>
            <td><b>Marca: </b></td>
            <td><input type="text" name="txtMar" value="" onkeypress="ValidaSoloLetras()"></td>
        </tr>
        <tr>
            <td><b>Modelo: </b></td>
            <td><input type="text" name="txtMod" value=""></td>
        </tr>
        <tr>
            <td><b>Color: </b></td>
            <td><input type="text" name="txtCol" value="" onkeypress="ValidaSoloLetras()"></td>
        </tr>
        <tr>
            <td><b>Año: </b></td>
            <td><input type="text" name="txtAño" value="" onkeypress="ValidaSoloNumeros()"></td>
        </tr>
        <tr>
            <td><b>Kilometros: </b></td>
            <td><input type="text" name="txtKil" value="" onkeypress="ValidaSoloNumeros()"></td>
        </tr>
        <tr>
            <td><b>Valor x Día: </b></td>
            <td><input type="text" name="txtVal" value=""></td>
        </tr>
        <tr>
            <td><b>Garantia x Día: </b></td>
            <td><input type="text" name="txtGar" value=""></td>
        </tr>
        <tr>
            <td><b></b></td>
            <td><input type="submit" name="btnRegistrar" style="width:160px; height:50px;" value="REGISTRAR"></td>
        </tr>
    </table>  
 

    <?php
        if($_POST['btnRegistrar']=="REGISTRAR"){
            include ("funciones.php");
            $cnn = Conectar();
            $pat = $_POST['txtPat'];
            $mar = $_POST['txtMar'];
            $mod = $_POST['txtMod']; 
            $col = $_POST['txtCol'];
            $año = $_POST['txtAño'];
            $kil = $_POST['txtKil'];
            $val = $_POST['txtVal'];   
            $gar = $_POST['txtGar'];  
            $estado = 'D';
        
            if($_POST['txtPat']==$pat){
                $rs = mysqli_query($cnn,"SELECT * FROM vehiculo WHERE patente='$pat'");
                if($row = mysqli_fetch_array($rs)){
                ?><script>alert("Ya existe un vehiculo registrado con esa Patente")</script><?php
                }else{
                    if(empty($mar) || empty($mod) || empty($col) || empty($año) || empty($kil) || empty($val) || empty($gar)){
                        ?><script>alert("Los campos obligatorios deben contener datos")</script><?php
                    }else{
                        $sql = "INSERT INTO vehiculo VALUES ('$pat','$mar','$mod','$col','$año','$kil','$val','$gar','$estado')";
                        echo $sql;
                        mysqli_query($cnn,$sql);
                        ?>
                        <script>alert("El Vehículo ha sido ingresado Correctamente")</script>
                        <?php
                    }
                }
            }else{ ?>
                <script>alert("Patente Incorrecta")</script>
            <?php    
            }
        }
    ?>

    </form>  
</body>
</html>