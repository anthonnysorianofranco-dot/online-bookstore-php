<?php
include("includes/conexion.php");

if (isset($_POST['guardar'])) {

    $sql = "INSERT INTO contacto (nombre, correo, fecha, asunto, comentario)
            VALUES (:nombre, :correo, :fecha, :asunto, :comentario)";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':nombre' => $_POST['nombre'],
        ':correo' => $_POST['correo'],
        ':fecha' => $_POST['fecha'],
        ':asunto' => $_POST['asunto'],
        ':comentario' => $_POST['comentario']
    ]);

    header("Location: index.php");
    exit();
}

if (isset($_GET['borrar'])) {

    $id = $_GET['borrar'];

    $sql = "DELETE FROM contacto WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: index.php");
    exit();
}

if (isset($_POST['actualizar'])) {

    $sql = "UPDATE contacto 
            SET nombre=:nombre, correo=:correo, fecha=:fecha, asunto=:asunto, comentario=:comentario
            WHERE id=:id";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':nombre' => $_POST['nombre'],
        ':correo' => $_POST['correo'],
        ':fecha' => $_POST['fecha'],
        ':asunto' => $_POST['asunto'],
        ':comentario' => $_POST['comentario'],
        ':id' => $_POST['id']
    ]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Grayscale - Start Bootstrap Theme</title>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <link href="css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#page-top">Libreria AnthSori</a>

        <button class="navbar-toggler navbar-toggler-right" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarResponsive">
            Menu <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#Sobre">Sobre</a></li>
                <li class="nav-item"><a class="nav-link" href="#Libros">Libros</a></li>
                <li class="nav-item"><a class="nav-link" href="#Comentar">Comentar</a></li>
                <li class="nav-item"><a class="nav-link" href="#Comentarios">Comentarios</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Masthead-->
<header class="masthead">
    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
        <div class="text-center">
            <h1 class="mx-auto my-0 text-uppercase">AnthSori</h1>
            <h2 class="text-white-50 mx-auto mt-2 mb-5">
                Abre un libro, abre tu mente, Tu escape a otros entornos, Donde las historias cobran vida y Más que libros, experiencias.
            </h2>
            <a class="btn btn-primary" href="#about">Empezar</a>
        </div>
    </div>
</header>

<!-- Sobre-->
<section class="about-section text-center" id="Sobre">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="text-white mb-4">Sobre Librería AnthSori</h2>

                <p class="text-white-50">
                    En <strong>Librería AnthSori</strong> creemos que cada libro es una puerta a nuevos mundos.
                    Nuestra plataforma te permite explorar una amplia colección de libros de diferentes géneros,
                    conocer a sus autores y compartir tus opiniones con otros lectores.
                </p>

                <p class="text-white-50">
                    Desde tecnología y negocios hasta cocina y psicología, aquí encontrarás contenido pensado
                    para aprender, entretenerte y crecer. Además, puedes interactuar dejando tus comentarios
                    y formando parte de nuestra comunidad.
                </p>

            </div>
        </div>

        <img class="img-fluid mt-4 rounded shadow" src="assets/img/ipad.png" alt="Librería AnthSori" />
    </div>
</section>

<!-- Libros-->
<section class="projects-section bg-light" id="Libros">
    <div class="container mt-5 pt-5">

        <h2 class="text-center mb-5">Libros disponibles</h2>

        <div class="row">

        <?php
        $sql = "SELECT 
            t.titulo,
            t.tipo,
            t.notas,
            t.fecha_pub,
            a.nombre AS nombre_autor,
            a.apellido AS apellido_autor,
            a.ciudad
        FROM titulos t
        LEFT JOIN titulo_autor ta ON t.id_titulo = ta.id_titulo
        LEFT JOIN autores a ON ta.id_autor = a.id_autor";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($libros as $libro) {
        ?>

            <div class="col-md-4 mb-4">
                <div class="card p-3 shadow">

                    <h4><?php echo $libro['titulo']; ?></h4>
                    <p><strong>Tipo:</strong> <?php echo $libro['tipo']; ?></p>
                    <p><strong>Fecha:</strong> <?php echo $libro['fecha_pub'] ?? 'No disponible'; ?></p>
                    <p><?php echo $libro['notas']; ?></p>

                    <hr>

                    <p><strong>Autor:</strong>
                        <?php echo ($libro['nombre_autor'] ?? 'Desconocido') . " " . ($libro['apellido_autor'] ?? ''); ?>
                    </p>

                    <p><strong>Ciudad:</strong> <?php echo $libro['ciudad'] ?? 'No disponible'; ?></p>

                </div>
            </div>

        <?php } ?>

        </div>
    </div>
</section>

<!-- Comentar-->
<section class="signup-section" id="Comentar">
    <div class="container">

        <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
        <h2 class="text-white mb-5">Tu opinion importa</h2>

        <form method="POST">
            <input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
            <input class="form-control mb-2" name="correo" placeholder="Correo" required>
            <input class="form-control mb-2" type="date" name="fecha" required>
            <input class="form-control mb-2" name="asunto" placeholder="Asunto" required>
            <textarea class="form-control mb-2" name="comentario" placeholder="Comentario" required></textarea>
            <button class="btn btn-primary" name="guardar">Enviar</button>
        </form>

    </div>
</section>

<!-- comentarios-->
<section class="contact-section bg-black" id="Comentarios">
    <div class="container px-4 px-lg-5">

        <h2 class="text-center text-white mb-5">Comentarios</h2>

        <div class="row">

        <?php
        $stmt = $conexion->query("SELECT * FROM contacto");
        $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($comentarios as $c) {
        ?>

            <div class="col-md-4 mb-3">
                <div class="card p-3">

                <?php if (isset($_GET['editar']) && $_GET['editar'] == $c['id']) { ?>

                    <form method="POST">

                        <input type="hidden" name="id" value="<?php echo $c['id']; ?>">

                        <input class="form-control mb-1" name="nombre" value="<?php echo $c['nombre']; ?>">
                        <input class="form-control mb-1" name="correo" value="<?php echo $c['correo']; ?>">
                        <input class="form-control mb-1" name="fecha" value="<?php echo $c['fecha']; ?>">
                        <input class="form-control mb-1" name="asunto" value="<?php echo $c['asunto']; ?>">
                        <textarea class="form-control mb-1" name="comentario"><?php echo $c['comentario']; ?></textarea>

                        <button class="btn btn-success btn-sm" name="actualizar">Guardar</button>

                    </form>

                <?php } else { ?>

                    <h5><?php echo $c['nombre']; ?></h5>
                    <p><?php echo $c['correo']; ?></p>
                    <p><?php echo $c['fecha']; ?></p>

                    <hr>

                    <h6><?php echo $c['asunto']; ?></h6>
                    <p><?php echo $c['comentario']; ?></p>

                    <a href="?editar=<?php echo $c['id']; ?>#Comentarios" class="btn btn-warning btn-sm">Editar</a>
                    <a href="?borrar=<?php echo $c['id']; ?>" class="btn btn-danger btn-sm">Borrar</a>

                <?php } ?>

                </div>
            </div>

        <?php } ?>

        </div>

        <div class="social d-flex justify-content-center">
            <a class="mx-2" href="mailto:anthonnysorianofranco@gmail.com">
                <i class="fas fa-envelope"></i>
            </a>

            <a class="mx-2" href="https://www.linkedin.com/in/anthonny-soriano-45b1683a0/">
                <i class="fab fa-linkedin"></i>
            </a>

            <a class="mx-2" href="https://github.com/anthonnysorianofranco-dot/online-bookstore-php.git">
                <i class="fab fa-github"></i>
            </a>
        </div>

    </div>
</section>

<!-- Footer-->
<footer class="footer bg-black small text-center text-white-50">
    <div class="container px-4 px-lg-5">
        Copyright &copy; Libreria AnthSori 2026
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

</body>
</html>