<?php redirectPages() ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaborHUB</title>
    <link rel="stylesheet" href="<?= base_url('Public/template/Css/adm.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Public/template/Images/favicon.png') ?>" type="image/x-icon">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">





</head>

<body>

    <?php $fotoPerfil = $_SESSION['usuarios_logado']->usuarios_imagem ?? ''; ?>

    <?php $usuarioTipo = $_SESSION['usuarios_logado']->pf_tipo ?? '' ?>

    <?php if ($usuarioTipo === 'Cliente'): ?>

        <?php $nomeUsuario = $_SESSION['usuarios_logado']->pf_nome . ' ' . $_SESSION['usuarios_logado']->pf_sobrenome; ?>



    <?php else: ?>

        <?php $nomeUsuario = $_SESSION['usuarios_logado']->pj_nomeFantasia ?? ''; ?>


    <?php endif; ?>


    <?php if (isset($_SESSION['msg'])): ?>

        <?php

        echo msg(
            $_SESSION['msg']['texto'],
            $_SESSION['msg']['color'],
        );

        unset($_SESSION['msg']);

        ?>

    <?php endif; ?>
    <main>
        <!-- Gatilho (Botão) -->
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <!-- Sidebar -->
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark min-vh-100">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white sticky-top">
                        <span class="fs-5 d-none d-sm-inline mt-3 mb-3"> <img class="perfil" src="<?= base_url($fotoPerfil) ?>" alt="Foto Escolhida"> <?= esc($nomeUsuario) ?></span>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item mt-4">
                                <a href="<?= base_url('adm/index') ?>" class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">DashBoard</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/listarClientes') ?>" class="nav-link px-0 align-middle text-white">
                                    <i class="bi bi-person fs-4"></i> <span class="ms-1 d-none d-sm-inline">Clientes</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('admin/listarProfissional') ?>" class="nav-link px-0 align-middle text-white">
                                    <i class="bi bi-building fs-4"></i> <span class="ms-1 d-none d-sm-inline">Profissionais</span>
                                </a>
                            </li>
                        </ul>

                        <hr>

                        <div class="sair">
                            <a href="<?= base_url('login/logout') ?>" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-arrow-bar-left fs-4"></i> <span class="ms-1 d-none d-sm-inline">Sair</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo Principal -->
                <div class="col py-3">
                    <h4>Listagem de Clientes</h4>
                    <div class="listagemBusca mt-4">

                        <form action="" role="search" method="POST">
                            <div class="row">
                                <div class="campo col-12 col-md-6 col-lg-4 input-group">
                                    <input type="search" name="buscarUsuario" class="form-control" aria-label="Search" placeholder="Pesquise por um cliente" id="buscarUsuario">
                                    <button type="button" class="btn btn-outline-primary">Buscar <i class="bi bi-search"></i> </button>

                                </div>


                            </div>
                        </form>


                    </div>


                    <div class="listaTabela ">

                        <div class="tabelaCliente">
                            <div class="botoes ">
                                <ul class="nav nav-underline">
                                    <li class="nav-item">
                                        <a class="nav-link" onclick="mostrar('cliente')" aria-current="page" href="#cliente">Pessoa Física</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" onclick="mostrar('profissional')" href="#profissional">Pessoa Jurídica</a>
                                    </li>

                                </ul>
                            </div>

                            <!-- cliente -->
                            <div class="table-responsive">
                                <table id="form-cliente" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Nome Completo</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Gênero</th>
                                            <th scope="col">Criado em</th>
                                            <th scope="col">Detalhar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($listarClientes)): ?>
                                            <p class="mt-5">Não há clientes de pessoa física cadastrado no sistema</p>
                                        <?php else: ?>
                                            <?php foreach ($listarClientes as $cliente): ?>
                                                <tr>
                                                    <td scope="row"><img class="cliente" src="<?= base_url($cliente->usuarios_imagem) ?>" alt=""></td>
                                                    <td><?= esc($cliente->nome) ?></td>
                                                    <td><?= esc($cliente->usuarios_email) ?> </td>
                                                    <td><?= esc($cliente->genero) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($cliente->usuarios_criado_em)) ?></td>
                                                    <td> <button type="button" onclick="window.location.href='<?= base_url('clientes/detalhes/' . $cliente->usuarios_id) ?>'" class="btn btn-outline-primary">Buscar <i class="bi bi-plus"></i> </button></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>


                                <!-- Profissional -->
                                <table id="form-profissional" style="display: none;" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Razão Social</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">CNPJ</th>
                                            <th scope="col">Criado em</th>
                                            <th scope="col">Detalhar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($listarClientePJ)): ?>
                                            <p class="mt-5">Não há clientes de pessoa jurídica cadastrado no sistema</p>
                                        <?php else: ?>
                                            <?php foreach ($listarClientePJ as $clientePJ): ?>
                                                <tr>
                                                    <td scope="row"><img class="cliente" src="<?= base_url($clientePJ->usuarios_imagem) ?>" alt=""></td>
                                                    <td><?= esc($clientePJ->nome) ?></td>
                                                    <td><?= esc($clientePJ->usuarios_email) ?></td>
                                                    <td><?= esc($clientePJ->documento) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($clientePJ->usuarios_criado_em)) ?></td>
                                                    <td> <button type="button" onclick="window.location.href='<?= base_url('clientes/detalhes/' . $clientePJ->usuarios_id) ?>'" class="btn btn-outline-primary">Detalhar <i class="bi bi-plus"></i> </button></td>
                                                </tr>

                                            <?php endforeach; ?>
                                        <?php endif; ?>


                                    </tbody>
                                </table>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>





    </main>


     <footer class="bg-dark text-center text-white py-4">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                    <h5 class="text-uppercase">LaborHUB</h5>
                    <p>
                        O sistema tem como finalidade de conectar cliente à prestadores de serviço a qualquer hora do dia
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-uppercase">Contato</h5>
                    <p>Email: laborhubconection@gmail.com</p>
                    <p>Telefone: (62) 9 9649-6240</p>
                </div>

                <!-- Ícones de Redes Sociais  -->
                <section class="mb-4">

                    <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/FelGomes" target="_blank" role="button">
                        <i class="bi bi-github"></i>
                    </a>

                    <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/dheniiel" target="_blank" role="button">
                        <i class="bi bi-github"></i>
                    </a>

                    <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/KaduDLF" target="_blank" role="button">
                        <i class="bi bi-github"></i>
                    </a>


                </section>

                <!-- Texto de Copyright  -->
                <div class="text-center p-3">
                    © 2026 Copyright: <a class="text-white" href="https://github.com/FelGomes">Equipe geral de desenvolvimento do LaborHUB</a>
                </div>
            </div>
    </footer>




    <!-- Boostrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="<?= base_url('Public/Js/timeAlert.js') ?>"></script>

    <script>
        function mostrar(tipo) {
            document.getElementById("form-cliente").style.display = 'none';
            document.getElementById("form-profissional").style.display = 'none';

            document.getElementById('form-' + tipo).style.display = 'table';

        }
    </script>


</body>

</html>