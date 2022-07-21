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
            <td colspan="4" align="center"><h1>Registro de Clientes</h1></td>
        </tr>
        <tr>
            <td><b>Rut: </b></td>
            <td><input type="text" name="txtRut" value="" onkeypress="ValidaSoloNumeros()"></td>
            <td>-</td>
            <td><input type="text" name="txtDigito" size="2" value=""></td>
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
            <td><input type="date" name="txtFec" style="width:160px" value=""></td>
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
                    <select name="txtSex" style="width:160px">
                        <?php echo'<option>'."Seleccione".'</option>';?>
                        <?php echo'<option>'."----------".'</option>';?>
                        <?php while ($row = mysqli_fetch_array($result)){
                            echo'<option>'.$row["descripcion"].'</option>';
                        }
                        ?>
                    </select> 
            </td>
        </tr>
        <tr>
            <td><b>Dirección: </b></td>
            <td><input type="text" name="txtDir" value=""></td>
        </tr>
        <tr>
            <td><b>Región: </b></td>
            <td>
                <?php
                    $sql = "SELECT nombreRegion FROM regiones ORDER BY id";
                    $result = mysqli_query($cnn,$sql);
                ?>
                    <select name="txtReg" style="width:160px">
                        <?php echo'<option>'."Seleccione".'</option>';?>
                        <?php echo'<option>'."----------".'</option>';?>
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
            <td><b>Correo: </b></td>
            <td><input type="text" name="txtCor" value=""></td>
        </tr>
        <tr>
            <td><b>Usuario: </b></td>
            <td><input type="text" name="txtUsu" value=""></td>
        </tr>
        <tr>
            <td><b>Contraseña: </b></td>
            <td><input type="text" name="txtCon" value=""></td>
        </tr>
        <tr>
            <td><b></b></td>
            <td><input type="submit" name="btnRegistrar" style="width:160px; height:50px;" value="REGISTRAR"></td>
        </tr>
    </table>  
 

    <?php
        if($_POST['btnRegistrar']=="REGISTRAR"){
            $dig = Verifica($_POST['txtRut']);
            $num = $_POST['txtRut'];
            $rut = $_POST['txtRut']."-".$_POST['txtDigito'];
            $nom = $_POST['txtNom']; 
            $ape = $_POST['txtApe'];
            $fec = $_POST['txtFec'];
            $sex = $_POST['txtSex'];
            $dir = $_POST['txtDir'];
            $reg = $_POST['txtReg'];
            $fon = $_POST['txtFon']; 
            $cor = $_POST['txtCor'];
            $usu = $_POST['txtUsu'];
            $con = $_POST['txtCon'];   
            if($_POST['txtDigito']=="k"){$_POST['txtDigito']='K';}
            if($_POST['txtDigito']==$dig){
                $rs = mysqli_query($cnn,"SELECT * FROM cliente WHERE rut='$rut'");
                if($row = mysqli_fetch_array($rs)){
                ?><script>alert("Ya existe un cliente registrado con ese Rut")</script><?php
                }else{
                    if(empty($nom) || empty($ape) || empty($fec) || empty($sex) || empty($dir) || empty($reg) || empty($fon) || empty($cor) || empty($usu) || empty($con)){
                        ?><script>alert("Los campos obligatorios deben contener datos")</script><?php
                    }else{
                        //Comparar y buscar la llave primaria de la tabla Sexo para insertar
                        $result1 = mysqli_query($cnn,"SELECT id FROM sexo WHERE descripcion='$sex'");
                        $rw1 = mysqli_fetch_array($result1);
                        $idSex = $rw1[0];
                        //Fin de Comparar y buscar tabla Sexo
                        //Comparar y buscar la llave primaria de la tabla Region para insertar
                        $result2 = mysqli_query($cnn,"SELECT id FROM regiones WHERE nombreRegion='$reg'");
                        $rw2 = mysqli_fetch_array($result2);
                        $idReg = $rw2[0];
                        //Fin de Comparar y buscar tabla Region
                        $sql = "INSERT INTO cliente VALUES ('$rut','$nom','$ape','$fec','$idSex','$dir','$idReg','$fon','$cor','$usu','$con')";
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