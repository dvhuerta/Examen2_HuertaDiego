<?php
include './service/moduloService.php';
session_start();

//INICIALIZACIÓN
$nombre = "";
$estado = "";
$codModulo = "";
$accion = "Agregar";
$eliminarMod = "Eliminar";
$moduloService = new ModuloService();

//CRUD
//AGREGAR
if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $moduloService->insert($_POST["codModulo"], $_POST["nombre"], $_POST["estado"]);
} 
//MODIFICAR
else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")) {
    $moduloService->update($_POST["nombre"],$_POST["codModulo"]);
} 
//SELECCIONAR ID A MODIFICAR
else if (isset($_GET["update"])) {
    $modulo = $moduloService->findByPK($_GET["update"]);
    if ($modulo!=null){
        $codModulo = $modulo["cod_modulo"];
        $nombre = $modulo["nombre"];
        $estado = $modulo["estado"];
        $accion = "Modificar";
    }
} 
//ELIMINAR
else if (isset($_POST["eliminarMod"])) {
    $moduloService->delete($_POST["eliminarMod"]);
}
$result = $moduloService->findAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Taller de acceso a BD con PHP</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">Examen</div>
            </a>
            <hr class="sidebar-divider my-0">
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="card-body">
                <h1>Examen</h1>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Inicio</h6>
                </div>
                <div class="table-responsive">
                    <form name="forma" id="forma" method="post" action="index.php">
                        <!-- BOTÓN ELIMINAR -->
                        <table border=0>
                            <tr>
                                <td colspan="3" style="width: 1080px;">&nbsp;</td>
                                <td><input type="button" name="eliminar" value="<?php echo $eliminarMod?>" onclick="eliminacionModulo()"></td>
                            </tr>
                        </table>
                        <!-- TABLA CLIENTE -->
                        <table border="1" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <!-- TÍTULOS -->
                            <tr>
                                <td>COD_MODULO</td>
                                <td>NOMBRE</td>
                                <td>ESTADO</td>
                                <td>ELIM</td>
                            </tr>
                            <?php
                            /* GUARDAR EN RESULT LOS DATOS DE LA TABLA */
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                            
                            <!-- IMPRESIÓN DE LA TABLA CON LOS DATOS DESDE LA BASE -->
                                    <tr>
                                        <td><a href="index.php?update=<?php echo $row["COD_MODULO"]; ?>"><?php echo $row["COD_MODULO"]; ?></a>
                                        </td>
                                        <td><?php echo $row["NOMBRE"]; ?></td>
                                        <td><?php echo $row["ESTADO"]; ?></td>
                                        <td><input type="radio" name="eliminarMod" value="<?php echo $row["COD_MODULO"]; ?>">
                                        </td>
                                    </tr>
                                <?php
                                }
                            } 
                            /* EN CASO DE NO EXISTIR DATOS EN LA TABLA */
                            else { ?>
                                <tr>
                                    <td colspan="4">NO HAY DATOS</td>;
                                </tr>
                            <?php } ?>
                        </table>
                        <!-- hidden ES PARA QUE LOS USUARIOS NO PUEDAN VER NI MODIFICAR DATOS CUANDO SE ENVÍA EN UN FORMULARIO, ESPECIALMENTE ID -->
                        <input type="hidden" name="codModulo" value="<?php echo $codModulo ?>">
                        <!-- CAMPOS PARA NUEVO MODULO -->
                        <table border="0">
                            <tr>
                                <td colspan=2><strong>Nuevo Cliente</strong></td>
                            </tr>
                            <tr>
                                <td><label id="lblModulo" for="codModulo">Código del Módulo: </label></td>
                                <td><input type="text" name="codModulo" id="codModulo" value="<?php echo $codModulo ?>" required></td>
                            </tr>
                            <tr>
                                <td><label id="lblNombre" for="nombre">Nombre: </label></td>
                                <td><input type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>" maxlength="100" size="25" required></td>
                            </tr>
                            <tr>
                                <td><label id="lblEstado" for="estado">ESTADO: </label></td>
                                <td><input type="text" name="estado" id="estado" value="<?php echo $estado ?>" maxlength="3" minlength="3" size="25" required></td>
                                <!-- <td><input type="radio" id="activo" name="estado" value="<?php $estado ="ACT"; ?>">
                                <label for="activo">ACTIVO</label>
                                <input type="radio" id="inactivo" name="estado" value="<?php $estado ="INA"; ?>">
                                <label for="inactivo">INACTIVO</label><br></td> -->
                            </tr>
                            <tr>
                                <td colspan=2><input type="submit" name="accion" value="<?php echo $accion ?>"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- CODIGO JAVA SCRIPT PARA HACER UN TYPE BUTTON EN SUBMIT -->
<script>
    function eliminacionModulo() {
        document.getElementById("forma").submit();
    }
</script>

</html>