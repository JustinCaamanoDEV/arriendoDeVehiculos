<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="contenedor">
    <header>
        <h1 class="title">Arriendo de Vehículos</h1>
        <a href="(27 Admin)nuevoCliente.php">Registrarse</a>
    </header>
        <div class="login">
        <article class="fondo">
          <img src="img/usuario.jpg" alt="User">
          <h3>Inicio de Sesión</h3>
          <form class="" method="post">
            <span class="icon-user"></span><input class="inp" type="text" name="txtUsuario" value=""><br>
            <span class="icon-key2"></span><input class="inp" type="password" name="txtPass" value=""><br>
            <input class="boton" type="submit" name="btnIngresar" value="INGRESAR">
            <br><br>
          </form>
        </article>
      </div>

    </div>

    <?php error_reporting(0);?> 
    <?php 
        if($_POST['btnIngresar']=="INGRESAR"){
            include("funciones.php");
            $cnn = Conectar();
            $usu = $_POST['txtUsuario'];
            $pass = $_POST['txtPass'];
            
            $sql ="select * from empleado where usuario='$usu' and contraseña='$pass'";
            
            $rs = mysqli_query($cnn, $sql);
                if(mysqli_num_rows($rs) != 0){
                    if($row = mysqli_fetch_array($rs)){
                        $datoNom = $row[nombres]." ".$row[apellidos];
                        $datoCar = $row[cargo];
                        switch($datoCar){
                            case ADM:
                                echo "<script>alert('Usted es $datoNom y es ADMINISTRADOR')</script>";
                                echo "<script type='text/javascript'>window.location='(4)menuAdministrador.html'</script>";
                                break;
                            case VND:
                                echo "<script>alert('Usted es $datoNom y es VENDEDOR')</script>";
                                echo "<script type='text/javascript'>window.location='(5)menuEmpleado.html'</script>";
                                break;  
                            default:
                                echo "<script>alert('Usted no es usuario')</script>";
                                echo "<script type='text/javascript'>window.location='login.php'</script>";
                                break;          
                        }
                    } 
                } else {
                    $sql1 ="select * from cliente where usuario='$usu' and contraseña='$pass'";
                    $rs = mysqli_query($cnn, $sql1);
                    if(mysqli_num_rows($rs) != 0){
                        if($row = mysqli_fetch_array($rs)){
                            $datoNom = $row[nombres]." ".$row[apellidos];
                            $datoSex = $row[sexo];
                            switch($datoSex){
                                case M:
                                    echo "<script>alert('Bienvenido $datoNom')</script>";
                                    echo "<script type='text/javascript'>window.location='(6)menuCliente.html'</script>";
                                    break;
                                case F:
                                    echo "<script>alert('Bienvenida $datoNom')</script>";
                                    echo "<script type='text/javascript'>window.location='(6)menuCliente.html'</script>";
                                    break; 
                                default:
                                    echo "<script>alert('Usted no es usuario')</script>";
                                    echo "<script type='text/javascript'>window.location='login.php'</script>";
                                    break;       
                            }
                        }           
                    } else{
                        echo "<script>alert('Usuario o Clave incorrecta')</script>";
                    }       
                          
                }
                
        }
    ?>
    </form>  
</body>
</html>

