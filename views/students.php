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
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Permanent+Marker&display=swap" rel="stylesheet">
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <li class="nav-item active w-100">
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
            <section id="students" class="container">
                <div class="row">
                    <div class="alert alert-success alert-dismissible align-items-center fade" role="alert" id="alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div id="successMensage">Aluno Cadastrado</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-danger align-items-center alert-dismissible fade" role="alert" id="alert-danger">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <div id="dangerMensage">Erro ao cadastrar Aluno</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Alunos</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAluno">+ Novo Aluno</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="tabelaAlunos" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Dt. inclusão</th>
                                    <th>Nome</th>
                                    <th>Curso</th>
                                    <th>Matrícula</th>
                                    <th>Situação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!--
                                    <td>20/03/2025</td>
                                    <td class="text-truncate">João da Silva Amaral</td>
                                    <td>Informática</td>
                                    <td>#####</td>
                                    <td>Ativo</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-bs-title="Detalhes">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-bs-title="Editar">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-bs-title="Excluir">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                    -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal fade" id="modalAluno" tabindex="-1" aria-labelledby="modalAlunoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAlunoLabel">Cadastrar Aluno</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" id="formAluno">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nameStudents" id="nameStudents" placeholder="Nome Completo" required>
                                                <label for="nameStudents" class="form-label">Nome Completo</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="###.###.###-##" required>
                                                <label for="cpf" class="form-label">CPF</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" name="birth" id="birth" placeholder="Selecione a data" required>
                                                <label for="birth" class="form-label">Data de Nascimento</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Número Telefone">
                                                <label for="phone" class="form-label">Telefone</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select name="course" id="course" class="form-select" required>
                                                    <option value="" selected disabled>Selecione</option>
                                                    <option value="informática">Informática</option>
                                                    <option value="empregabilidade">Empregabilidade</option>
                                                    <option value="marketing">Marketing Digital</option>
                                                </select>
                                                <label for="course" class="form-label">Curso</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select name="situation" id="situation" class="form-select" required>
                                                    <option value="ativo">Ativo</option>
                                                    <option value="inativo">Inativo</option>
                                                    <option value="concluido">Concluído</option>
                                                </select>
                                                <label for="situation" class="form-label">Situação</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select name="sex" id="sex" class="form-select" required>
                                                    <option selected disabled>Selecione</option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Feminino</option>
                                                    <option value="Não Informar">Não Informar</option>
                                                </select>
                                                <label for="sex" class="form-label">Sexo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="cep" id="cep" placeholder="Cep" required>
                                                <label for="cep" class="form-label">Cep</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="address" id="address" placeholder="Endereço" required>
                                                <label for="address" class="form-label">Endereço</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="number" id="number" placeholder="número" required>
                                                <label for="number" class="form-label">Número</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="complemento" id="complemento" placeholder="complemento">
                                                <label for="complemento" class="form-label">Complemento</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" name="neighborhood" id="neighborhood" class="form-control" placeholder="Bairro" required>
                                                <label for="neighborhood" class="form-label">Bairro</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-floating">
                                                <input type="text" name="city" id="city" class="form-control" placeholder="Cidade" readonly>
                                                <label for="city" class="form-label">Cidade</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <select name="state" id="state" class="form-select">
                                                    <option selected disabled>Estado</option>
                                                    <option value="AC">AC</option>
                                                    <option value="AL">AL</option>
                                                    <option value="AP">AP</option>
                                                    <option value="AM">AM</option>
                                                    <option value="BA">BA</option>
                                                    <option value="CE">CE</option>
                                                    <option value="DF">DF</option>
                                                    <option value="ES">ES</option>
                                                    <option value="GO">GO</option>
                                                    <option value="MA">MA</option>
                                                    <option value="MT">MT</option>
                                                    <option value="MS">MS</option>
                                                    <option value="MG">MG</option>
                                                    <option value="PA">PA</option>
                                                    <option value="PB">PB</option>
                                                    <option value="PR">PR</option>
                                                    <option value="PE">PE</option>
                                                    <option value="PI">PI</option>
                                                    <option value="RJ">RJ</option>
                                                    <option value="RN">RN</option>
                                                    <option value="RS">RS</option>
                                                    <option value="RO">RO</option>
                                                    <option value="RR">RR</option>
                                                    <option value="SC">SC</option>
                                                    <option value="SP">SP</option>
                                                    <option value="SE">SE</option>
                                                    <option value="TO">TO</option>
                                                </select>
                                                <label for="state" class="form-label">Estado</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" id="btnSubmit">Salvar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
                        Tem certeza que deseja excluir este aluno?
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
    <script src="../js/app/students.js"></script>
</body>
</html>