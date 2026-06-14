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



    <main>

        <?php if (isset($_SESSION['msg'])): ?>

            <?php

            echo msg(
                $_SESSION['msg']['texto'],
                $_SESSION['msg']['color'],
            );

            unset($_SESSION['msg']);




            ?>
        <?php endif; ?>

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

                <div class="col pt-3">
                    <h4 class="mb-5">Area Restrita</h4>

                    <div class="listagem mt-4">

                        <div class="cardList">
                            <h5>Cliente mais assíduo</h5>
                            <p class="mb-4">Clientes que mais contrataram serviços</p>

                            <?php if (empty($clienteAssiduo)): ?>

                                <p class="mt-5">Nenhuma pessoa física solicitou serviço</p>

                            <?php else: ?>

                                <?php foreach ($clienteAssiduo as $cliente): ?>

                                    <div class="personInfo ">
                                        <div class="person">
                                            <img class="cliente" src="<?= base_url($cliente->usuariosImagem) ?>" alt="">
                                        </div>

                                        <div class="info">
                                            <h6><?= esc($cliente->nome) ?></h6>
                                            <p><?= esc($cliente->total) ?> Solicitações nos últimos mês</p>
                                        </div>


                                    </div>
                                <?php endforeach; ?>

                            <?php endif; ?>


                        </div>


                        <div class="cardList">
                            <h5>Empresa mais assídua</h5>
                            <p class="mb-4">Empresa que mais contrataram serviços</p>


                            <?php if (empty($profissionalAssiduo)): ?>

                                <p class="mt-5">Nenhuma pessoa jurídica solicitou serviço</p>

                            <?php else: ?>

                                <?php foreach ($profissionalAssiduo as $profissional): ?>

                                    <div class="personInfo ">
                                        <div class="person">
                                            <img class="cliente" src="<?= base_url($profissional->usuariosImagem) ?>" alt="">
                                        </div>

                                        <div class="info">
                                            <h6><?= esc($profissional->nome) ?></h6>
                                            <p><?= ($profissional->total) ?> Solicitações nos últimos mês</p>
                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>


                        </div>

                        <div class="cardList">
                            <h5>Serviço prestado</h5>
                            <p class="mb-4">Maiores serviços prestados</p>

                            <?php if (empty($servicos)): ?>

                                <p class="mt-5">Não há nenhum serviço exercido no último mês</p>


                            <?php else: ?>
                                <?php foreach ($servicos as $servicos): ?>
                                    <div class="personInfo ">
                                        <div class="person">
                                            <img class="cliente" src="<?= base_url($servicos->usuariosImagem) ?>" alt="">
                                        </div>

                                        <div class="info">
                                            <h6><?= esc($servicos->nome) ?></h6>
                                            <p><?= esc($servicos->servicos_nome) ?></p>
                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>


                        </div>




                    </div>

                    <!-- <div class="grafico">

                        <div class="listaGrafico">
                            <div id="myPlot" style="width:100%;max-width:700px">

                            </div>


                        </div>

                    </div> -->



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

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="<?= base_url('Public/Js/timeAlert.js') ?>"></script>


    <script>
        const xArray = [20, 9, 14, 4, 5];
        const yArray = ["Pedreiro", "Encanador", "Eletricista", "Servente", "Marceneiro"];

        const data = [{
            x: xArray,
            y: yArray,
            type: "bar",
            orientation: "h",
            marker: {
                color: "#3B82F6"
            }
        }]

        const layout = {
            title: "Serviços mais procurados"
        };
        Plotly.newPlot("myPlot", data, layout, {
            displayModeBar: false
        });
    </script>


</body>

</html>