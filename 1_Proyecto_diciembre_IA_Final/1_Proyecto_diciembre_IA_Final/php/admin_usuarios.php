<?php
session_start();
require_once 'conexion.php';

$listaDeCorreosAutorizados = [
    'daniel.cahisa@laginesta.com', 
    'david@active360.com'
];

$es_admin = false;

if (isset($_SESSION['id'])) {
    $idUser = $_SESSION['id'];
    
    $consultaDeSeguridad = $con->prepare("SELECT correo FROM usuarios WHERE id = ?");
    $consultaDeSeguridad->bind_param("i", $idUser);
    $consultaDeSeguridad->execute();
    
    $res = $consultaDeSeguridad->get_result();
    
    if ($usuarioEncontrado = $res->fetch_assoc()) {
        if (in_array($usuarioEncontrado['correo'], $listaDeCorreosAutorizados)) {
            $es_admin = true;
        }
    }
    $consultaDeSeguridad->close();
}

if (!$es_admin) {
    header("Location: index.php");
    exit;
}

$ordenParaTraerUsuarios = "SELECT * FROM usuarios ORDER BY id DESC";
$cajaConTodosLosUsuarios = $con->query($ordenParaTraerUsuarios);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administració d'Usuaris - Active360</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
       <?php require_once 'cabezera.php'; ?>
    </header>

    <main class="admin-main">
        <div class="admin-container">
            <h1>Gestió d'Usuaris</h1>
            <p>Panell d'administració exclusiu.</p>

            <?php if ($cajaConTodosLosUsuarios && $cajaConTodosLosUsuarios->num_rows > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Cognoms</th>
                                <th>Correu</th>
                                <th>Gènere</th>
                                <th>Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($usuarioIndividual = $cajaConTodosLosUsuarios->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuarioIndividual['id']) ?></td>
                                    <td><?= htmlspecialchars($usuarioIndividual['nombre']) ?></td>
                                    <td><?= htmlspecialchars($usuarioIndividual['apellidos']) ?></td>
                                    <td><?= htmlspecialchars($usuarioIndividual['correo']) ?></td>
                                    <td>
                                        <?php 
                                            if($usuarioIndividual["genero"] == "masculino") echo "Home";
                                            elseif($usuarioIndividual["genero"] == "femenino") echo "Dona";
                                            else echo "NS/NC";
                                        ?>
                                    </td>
                                    <td class="actions-cell">
                                        <a href="editar_usuario.php?id=<?= $usuarioIndividual['id'] ?>" class="btn-action btn-edit" title="Editar">
                                            ✏️
                                        </a>
                                        <a href="eliminar_usuario.php?id=<?= $usuarioIndividual['id'] ?>" class="btn-action btn-delete" title="Eliminar" onclick="return confirm('Estàs segur que vols eliminar aquest usuari?');">
                                            ❌
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <p>No hi ha usuaris registrats.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>