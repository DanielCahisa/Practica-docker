<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexion.php'; 

$directorioActualDelServidor = dirname($_SERVER['PHP_SELF']);

if (strpos($directorioActualDelServidor, '/php') !== false) {
    $rutaRelativaParaArchivosPHP  = './';       
    $rutaRelativaParaImagenes  = '../img/';
    $rutaRelativaParaEstilosCSS  = '../css/';
} elseif (strpos($directorioActualDelServidor, '/html') !== false) {
    $rutaRelativaParaArchivosPHP  = '../php/';  
    $rutaRelativaParaImagenes  = '../img/';
    $rutaRelativaParaEstilosCSS  = '../css/';
} else {
    $rutaRelativaParaArchivosPHP  = 'php/';
    $rutaRelativaParaImagenes  = 'img/';
    $rutaRelativaParaEstilosCSS  = 'css/';
}

$nombreDelArchivoActual = basename($_SERVER['PHP_SELF']);

$listaDePaginasAbiertasATodoElMundo = [
    'index.php',
    'area-client.php',
    'registro.php',
    'Login.php',
    'recuperar.php',    
    'token.php',        
    'restablecer.php', 
];

if (!in_array($nombreDelArchivoActual, $listaDePaginasAbiertasATodoElMundo)) {
    if (!isset($_SESSION['id']) || !isset($_SESSION['nombre'])) {
        header("Location: " . $rutaRelativaParaArchivosPHP . "area-client.php");
        exit();
    }
}

$listaDeCorreosAdministradores = ['daniel.cahisa@laginesta.com', 'david@active360.com']; 
$elUsuarioEsAdministrador = false;

if (isset($_SESSION['id'])) {
    $consultaParaVerificarPermisosDeAdmin = $con->prepare("SELECT correo FROM usuarios WHERE id = ?");
    $consultaParaVerificarPermisosDeAdmin->bind_param("i", $_SESSION['id']);
    $consultaParaVerificarPermisosDeAdmin->execute();
    
    $resultadoDeLaConsultaAdmin = $consultaParaVerificarPermisosDeAdmin->get_result();
    
    if ($datosDelUsuarioParaAdmin = $resultadoDeLaConsultaAdmin->fetch_assoc()) {
        if (in_array($datosDelUsuarioParaAdmin['correo'], $listaDeCorreosAdministradores)) {
            $elUsuarioEsAdministrador = true;
        }
    }
    $consultaParaVerificarPermisosDeAdmin->close();
}

function obtenerClaseSiEsLaPaginaActiva($nombreDelArchivoDelEnlace) {
    return basename($_SERVER['PHP_SELF']) === $nombreDelArchivoDelEnlace ? 'active-category-cab' : '';
}
?>

<link rel="stylesheet" href="<?php echo $rutaRelativaParaEstilosCSS; ?>cabezera.css">

<header class="header-cab">
    <nav class="nav-cab">

        <div class="logo-cab">
            <a href="<?php echo $rutaRelativaParaArchivosPHP; ?>index.php">
                <img src="<?php echo $rutaRelativaParaImagenes; ?>logo.png" alt="Active360 Logo">
            </a>
        </div>

        <ul class="nav-menu-cab">
            <?php if (isset($_SESSION['id'])): ?>
                <li><a href="<?php echo $rutaRelativaParaArchivosPHP; ?>blog.php" class="<?= obtenerClaseSiEsLaPaginaActiva('blog.php') ?>">BLOG</a></li>
                <li><a href="<?php echo $rutaRelativaParaArchivosPHP; ?>comunidad.php" class="<?= obtenerClaseSiEsLaPaginaActiva('comunidad.php') ?>">COMUNITAT</a></li>
                <li><a href="<?php echo $rutaRelativaParaArchivosPHP; ?>videos.php" class="<?= obtenerClaseSiEsLaPaginaActiva('videos.php') ?>">VIDEOS</a></li>
                <li><a href="<?php echo $rutaRelativaParaArchivosPHP; ?>ai-coach.php" class="<?= obtenerClaseSiEsLaPaginaActiva('ai-coach.php') ?>">AI COACH</a></li>
                
                <?php if ($elUsuarioEsAdministrador): ?>
                    <li>
                        <a href="<?php echo $rutaRelativaParaArchivosPHP; ?>admin_usuarios.php" class="<?= obtenerClaseSiEsLaPaginaActiva('admin_usuarios.php') ?>" style="color: #a0284c;">
                            USUARIOS
                        </a>
                    </li>
                <?php endif; ?>

            <?php endif; ?>
        </ul>

        <div class="button-cab">
            <?php if (isset($_SESSION['nombre'])): ?>
                <a href="<?php echo $rutaRelativaParaArchivosPHP; ?>logout.php" class="link-cab">Salir</a>
                <button class="link-cab"><?= htmlspecialchars($_SESSION['nombre']) ?></button>
            <?php else: ?>
                <a href="<?php echo $rutaRelativaParaArchivosPHP; ?>area-client.php" class="reg-in-cab">Iniciar sesión</a>
                <a href="<?php echo $rutaRelativaParaArchivosPHP; ?>registro.php" class="reg-in-cab">Registrarse</a>
            <?php endif; ?>
        </div>

    </nav>
</header>