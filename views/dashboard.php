<?php include '../controllers/protect.php'; ?>

<!DOCTYPE html>
<html lang="pt-RB">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Esta página é relacionada a ONG Solidariedade com finalidade de inclusão digital jovens e adultos em situação de vulnerabilidade social.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--FavIcon-->
    <link rel="shortcut icon" href="../Assets/img/FavIcon.png" type="image/x-icon">
    <!--Google Font PreLoad-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>SISONG Sistema de Gerenciamento Interno</title>
    <!--Google Fontes-->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Permanent+Marker&display=swap" rel="stylesheet">
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery (necessário para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/app/index.css">
</head>
<body>
    <div id="app">
        <aside class="bg-dark text-white py-3" id="aside-menu">
            <div class="logo d-flex flex-column align-items-center p-3">
                <h5 class="mb-4 text-center">Sistema ONG</h5>
                <div id="logo"></div>
            </div>
            <ul class="nav flex-column align-items-start ps-4">
                <li class="nav-item active w-100">
                    <a href="dashboard.php" class="nav-link text-white">
                        <i class="bi bi-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a href="students.php" class="nav-link text-white">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Alunos</span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a href="courses.php" class="nav-link text-white">
                        <i class="bi bi-book"></i>
                        <span>Cursos</span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-gear"></i>
                        <span>Configurações</span>
                    </a>
                </li>
            </ul>
        </aside>
        <main class="p-4" id="main-content">
            <header>
                <nav class="navbar navbar-light bg-light shadow-sm mb-4">
                    <button class="btn btn-light" id="menu-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <span class="navbar-brand">Bem-vindo(a), Funcionário</span>
                    <div class="dropdown">
                        <a href="#" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">Perfil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../controllers/auth.php?action=logout">Sair</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <section id="dashboard" class="container">
                <div class="row">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>Você possui inscrições pendentes para aprovação.</div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total de Alunos</h5>
                                <p class="fs-3 fw-bold text-primary">125</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Cursos Ativos</h5>
                                <p class="fs-3 fw-bold text-success">8</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Próximas Turmas</h5>
                                <p class="fs-3 fw-bold text-warning">3</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4 shadow-sm same-height" id="chartCardRow">
                            <div class="card-header">Inscrições por mês</div>
                            <div class="card-body">
                                <canvas id="chartInscricoes" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm same-height" id="chartCardPizza">
                            <div class="card-header">Modalidade Cursos</div>
                            <div class="card-body">
                                <canvas id="chartModalidades" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header">Últimos Alunos Cadastrados</div>
                            <div class="card-body">
                                <table id="tabelaAlunos" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Curso</th>
                                            <th>Data de Inscrição</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Maria Oliveira</td>
                                            <td>Informática Básica</td>
                                            <td>10/05/2025</td>
                                        </tr>
                                        <tr>
                                            <td>João Silva</td>
                                            <td>Culinária</td>
                                            <td>12/05/2025</td>
                                        </tr>
                                        <tr>
                                            <td>Ana Souza</td>
                                            <td>Design Gráfico</td>
                                            <td>13/05/2025</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!--BootStrap JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!--JavaScript-->
    <script src="../js/app/layout.js"></script>
    <script src="../js/app/dashboard.js"></script>
</body>
</html>