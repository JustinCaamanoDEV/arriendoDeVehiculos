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
    <form name="form1" method="post">
    <?php error_reporting(0);?> 
    <table border="0" align="center">
        <tr>
            <td colspan="4" align="center"><h1>Registro de Clientes</h1></td>
        </tr>
        <tr>
            <td><b>Rut: </b></td>
            <td><input type="text" name="txtRut" value="" onkeypress="ValidaSoloNumeros()"></td>
            <td>-</td>
            <td><input type="text" name="txtDigito" size="2" value=""></td>
        </tr>
        <tr>
            <td><b>Nombres: </b></td>
            <td><input type="text" name="txtNom" value="" onkeypress="ValidaSoloLetras()"></td>
        </tr>
        <tr>
            <td><b>Apellidos: </b></td>
            <td><input type="text" name="txtApe" value="" onkeypress="ValidaSoloLetras()"></td>
        </tr>
        <tr>
            <td><b>Fecha de Nacimiento: </b></td>
            <td><input type="date" name="txtFec" style="width:173px" value=""></td>
        </tr>
        <tr>
            <td><b>Sexo: </b></td>
            <td>
                <?php
                    include ("funciones.php");
                    $cnn = Conectar();
                    $sql = "SELECT descripcion FROM sexo";
                    $result = mysqli_query($cnn,$sql);
                ?>
                    <select name="txtSex" style="width:173px">
                        <?php while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["descripcion"].'</option>';
                        }
                        ?>
                    </select> 
            </td>
        </tr>
        <tr>
            <td><b>Región: </b></td>
            <td>
                <?php
                    $sql = "SELECT nombreRegion FROM regiones";
                    $result = mysqli_query($cnn,$sql);
                ?>
                    <select name="txtReg" style="width:173px">
                        <?php while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["nombreRegion"].'</option>';
                        }
                        ?>
                    </select>    
            </td>
        </tr>
        <tr>
            <td><b>Fono: </b></td>
            <td><input type="text" name="txtFon" value="" onkeypress="ValidaSoloNumeros()"></td>
        </tr>
        <tr>
            <td><b></b></td>
            <td><input type="submit" name="btnRegistrar" value="Registrar"></td>
        </tr>
    </table>  
 

    <?php
        if($_POST['btnRegistrar']=="Registrar"){
            $dig = Verifica($_POST['txtRut']);
            $num = $_POST['txtRut'];
            $rut = $_POST['txtRut']."-".$_POST['txtDigito'];
            $nom = $_POST['txtNom']; 
            $ape = $_POST['txtApe'];
            $fec = $_POST['txtFec'];
            $sex = $_POST['txtSex'];
            $reg = $_POST['txtReg'];
            $fon = $_POST['txtFon'];    
            if($_POST['txtDigito']=="k"){$_POST['txtDigito']='K';}
            if($_POST['txtDigito']==$dig){
                $rs = mysqli_query($cnn,"SELECT * FROM clientes WHERE rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                ?><script>alert("Ya existe un cliente registrado con ese Rut")</script><?php
                }else{
                    if(empty($nom) || empty($ape) || empty($fec) || empty($sex) || empty($reg) || empty($fon)){
                        ?><script>alert("Los campos obligatorios deben contener datos")</script><?php
                    }else{
                        $sql = "INSERT INTO clientes VALUES ('$rut','$nom','$ape','$fec','$sex','$reg','$fon')";
                        mysqli_query($cnn,$sql);
                        ?>
                        <script>alert("El Registro ha sido ingresado Correctamente")</script>
                        <?php
                    }
                }
            }else{ ?>
                <script>alert("Rut Incorrecto")</script>
            <?php    
            }
        }
    ?>

    </form>  
</body>
</html>