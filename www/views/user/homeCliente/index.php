<?php redirectPages() ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaborHUB</title>
    <link rel="stylesheet" href="<?= base_url('Public/template/Css/home.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Public/template/Images/favicon.png') ?>" type="image/x-icon">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">




</head>

<body>
    <header>

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


        <div class="topo mt-3">
            <!-- <div class="logo "> -->
            <a href="<?= base_url('user/homeCliente/index') ?>" class="logo-link navbar-brand"> <img src="<?= base_url('Public/template/Images/Texto do seu parágrafo(3).png') ?>" class="logo" alt="Foto Escolhida"> </a>
            <!-- </div> -->

            <div class="imagem">
                <img src="<?= base_url($fotoPerfil) ?>" alt="Foto Escolhida" data-bs-toggle="offcanvas" data-bs-target="#sidebarPerfil">
            </div>



        </div>

        <nav>
            <ul class="mt-1 mb-5 ">
                <li><a href="<?= base_url('user/homeCliente/index') ?>">Home</a></li>
                <li><a href="<?= base_url('historico/index') ?>">Histórico</a></li>
                <li><a href="<?= base_url('agenda/index') ?>">Agenda</a></li>

            </ul>

        </nav>
    </header>

    <main>


        <div class="offcanvas offcanvas-end" style="height: 100vh" tabindex="-1" id="sidebarPerfil">

            <div class="offcanvas-header">
                <div class="comentImage">
                    <img class="Imagecomentario" style="border-radius: 50% !important;" src="<?= base_url($fotoPerfil) ?>" alt="">

                </div>
                <h5> &nbsp; <?= esc($nomeUsuario); ?></h5>
                <br>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas">
                </button>
            </div>

            <div class="offcanvas-body">
                <div class="links">
                    <a class="linksEdicoes" href="<?= base_url('usuario/editCliente/' . $_SESSION['usuarios_logado']->usuarios_id) ?>"><i class="bi bi-person-plus-fill fs-3"></i> &nbsp; Editar perfil</a>
                    <a class="linksEdicoes" href="<?= base_url('login/logout') ?>"><i class="bi bi-box-arrow-left fs-3"></i> &nbsp; Sair</a>
                </div>


            </div>

        </div>


        <section> <!-- De busca -->
            <div class="container-fluid mt-2 pt-2">
                <div class="busca mt-2">
                    <h5 class="mt-2">Encontre o profissional ideal para suas demandas</h5>
                    <p class="text-center">Conectamos os melhores profissionais da sua região com você!</p>
                </div>

                <div class="search mt-2">
                    <div class="col-md-3 mb-4">
                        <input type="search" name="pesquisar" class="form-control" placeholder="Pesquisar por profissional" id="pesquisar">

                    </div>
                </div>

            </div>



        </section>


        <section> <!-- listagem dos profissionais -->

            <div id="principal" class="container container-custom border mt-4 mb-5 pb-4">
                <div class="titulo mt-3">
                    <h4 class="text-center">Profissionais que estão perto de você</h4>
                    <p class="text-center">Veja profissionais e empresa que estão próxima de você</p>
                </div>

                <div class="profissionais">


                    <?php if (empty($listaProfissionais)): ?>
                        <h4 class="text-center mt-5">Não encontramos nenhum profissional no estado de Goiás</h4>



                    <?php else: ?>



                        <div class="listagem">

                            <?php foreach ($listaProfissionais as $profissionais): ?>

                                <div class="item  mb-3">
                                    <p id="tipoServico" class="text-end"><?= esc($profissionais->servico) ?></p>
                                    <div class="perfil">
                                        <div class="foto">
                                            <img src="<?= base_url($profissionais->fotoPerfil) ?>" alt="Foto">
                                        </div>
                                        <div class="info">
                                            <h4><strong><?= esc($profissionais->nome) ?></strong></h4>
                                            <p><?= esc($profissionais->cidade . ', ' . $profissionais->uf) ?></p>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>

                                                <?php if ($i <= $profissionais->mediaAvaliacao): ?>
                                                    <i class="bi bi-star-fill" style="color: gold;"></i>

                                                <?php else: ?>
                                                    <i class="bi bi-star"></i>

                                                <?php endif; ?>

                                            <?php endfor; ?>
                                            <?= $profissionais->totalAvaliacoes . ' ' . '(' . number_format($profissionais->mediaAvaliacao, 1, '.', ',') . ')' ?>

                                            <h6 class="mt-2"><strong>Atendimento: </strong> <?= esc($profissionais->atendimento) ?></h6>
                                        </div>

                                    </div>

                                    <div class="texto mt-3">
                                        <h4><strong>Observação</strong></h4>
                                        <!-- FUnção para limitar o numero de caracter que ira mostrar na tela -->
                                        <p> <?= esc($profissionais->experiencia . ': ' . mb_strimwidth($profissionais->descricao, 0, 70, "...")); ?></p>
                                    </div>

                                    <div class="valor">
                                        <h4>R$: <?= number_format($profissionais->valor, 2, ',', '.') . ' - ' . ($profissionais->cobranca) ?></h4>
                                    </div>
                                    <?php
                                    ?>
                                    <div class="botoes mb-2">
                                        <button type="button" class="btn-perfil" onclick="window.location.href='<?= base_url('profissionais/perfil/' . $profissionais->usuarios_id); ?>'" name="verPerfil">Ver perfil</button>
                                    </div>


                                </div>



                            <?php endforeach; ?>

                        </div>



                    <?php endif; ?>

                </div>

            </div>

        </section>


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
                    <p>Email: laborhubconection.com</p>
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


</body>

</html>