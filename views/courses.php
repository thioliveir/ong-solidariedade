<?php include '../controllers/protect.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
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
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Permanent+Marker&display=swap" rel="stylesheet">
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- InputMask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
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
                <li class="nav-item w-100">
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
                <li class="nav-item active w-100">
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
            <section id="courses" class="container">
                <div class="row">
                    <div class="alert alert-success alert-dismissible align-items-center fade" role="alert" id="alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div id="successMensage">Curso Cadastrado</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger align-items-center alert-dismissible fade" role="alert" id="alert-danger">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <div id="dangerMensage">Erro ao cadastrar Curso</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Cursos</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCursos">+ Novo Curso</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="tabelaCursos" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome do Curso</th>
                                    <th>Modalidade</th>
                                    <th>Carga horária</th>
                                    <th>Turno</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--
                                <tr>
                                    
                                    <td>Informática</td>
                                    <td>EAD</td>
                                    <td>600h</td>
                                    <td>Noite</td>
                                    <td>Ativo</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-bs-title="Detalhes" id="btnDetails">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-bs-title="Editar">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-bs-title="Excluir">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                    
                                </tr>
                                -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal fade" id="modalCursos" tabindex="-1" aria-labelledby="modalCursosLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCursosLabel">Cadastrar Curso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" id="formCursos">
                                    <input type="hidden" id="inputIdCurso" name="id" value="">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Curso" required>
                                                <label for="nome" class="form-label">Nome do Curso</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select name="modalidade" id="modalidade" class="form-select" required>
                                                    <option value="" selected disabled>Selecione</option>
                                                    <option value="EAD">EAD</option>
                                                    <option value="Presencial">Presencial</option>
                                                    <option value="Híbrido">Híbrido</option>
                                                </select>
                                                <label for="modalidade" class="form-label">Modalidade</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="number" name="carga_horaria" id="carga_horaria" class="form-control" placeholder="Carga Horária" min="8" max="7200" data-bs-toggle="tooltip" title="de 8 e 7200" required>
                                                <label for="carga_horaria" class="form-label">Carga Horária</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label d-block mb-2">Turno</label>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="turno[]" id="turno-manha" class="form-check-input" value="Manhã">
                                                <label for="turno-manha" class="form-check-label">Manhã</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="turno[]" id="turno-tarde" class="form-check-input" value="Tarde">
                                                <label for="turno-tarde">Tarde</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="turno[]" id="turno-noite" class="form-check-input" value="Noite">
                                                <label for="turno-noite">Noite</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="date" name="data_inicio" id="data_inicio" class="form-control" placeholder="Data de Início" required>
                                                <label for="data_inicio" class="form-label">Data Inicio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="date" name="data_fim" id="data_fim" class="form-control" placeholder="Data de Fim" required>
                                                <label for="data_fim" class="form-label">Data Fim</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="number" name="qtd_max_alunos" id="qtd_max_alunos" class="form-control" placeholder="Quantidade de Alunos" required>
                                                <label for="qtd_max_alunos" class="form-label">Qtd de Alunos</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="ativo">Ativo</option>
                                                    <option value="inativo">Inativo</option>
                                                </select>
                                                <label for="status" class="form-label">Situação</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <textarea name="descricao" id="descricao" class="form-control" placeholder="Descrição do Curso" rows="3"></textarea>
                                                <label for="descricao" class="form-label">Descrição</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success" id="btnSubmit">Cadastrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </main>
        <!-- Modal de exclusão -->
        <div class="modal fade" id="modalConfirmarExclusao" tabindex="-1" aria-labelledby="modalConfirmarExclusaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja excluir este curso?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">Excluir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!--BootStrap JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!--JavaScript-->
    <script src="../js/app/layout.js"></script>
    <script src="../js/app/courses.js"></script>
</body>
</html>