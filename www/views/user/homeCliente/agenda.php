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
                <li><a href="#">Agenda</a></li>

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


        <div class="lista-servico">
            <div class="servicos-groups border">
                <h6>Serviços Ativos <i style="color: #3B82F6" class="bi-tools "></i></h6>
                <p> <?= $contadorAtivo->total ?> Servico(s) ativos.</p>

            </div>

            <div class="servicos-groups border">
                <h6>Serviços Concluidos <i style="color: #22C55E" class="bi bi-check2-circle "></i></h6>
                <p> <?= $contadorFinalizado->total ?> Servico(s) finalizados</p>

            </div>

            <div class="servicos-groups border">
                <h6>Serviços Pendentes <i style="color: #FACC15" class="bi bi-question-lg"></i></h6>
                <p> <?= $contadorPendente->total ?> Servico(s) Pendentes</p>

            </div>

            <div class="servicos-groups border">
                <h6>Serviços Recusados <i style="color: #FF4E4E" class="bi bi-x-circle"></i></h6>
                <p> <?= $contadorRecusado->total ?> Servico(s) Recusados</p>

            </div>

        </div>

        <!-- Caixa do foreach -->
        <div class="conteudo">

            <?php if (empty($ativos)): ?>

                <div> Não há nenhum serviço ativo no momento</div>

            <?php else: ?>

                <?php foreach ($ativos as $ativos): ?>

                    <div class="listagemAtivas">

                        <div class="listaAtivos">

                            <div class="perfilAtivo">
                                <div class="perfilAtivo">
                                    <div class="imgAtivo">
                                        <img src="<?= base_url($ativos->usuariosImagem) ?>" alt="foto">
                                    </div>
                                    <div class="infoAtivo mt-2">
                                        <h4 class="mb-2"><strong><?= esc($ativos->nome) ?></strong></h4>
                                        <p><strong>Telefone: </strong> <?= esc($ativos->telefone) ?></p>
                                        <P><strong>Cidade: </strong> <?= esc($ativos->cidade) ?></P>
                                    </div>
                                </div>

                            </div>


                            <div class="servicoAtivo">
                                <h5><?= esc($ativos->servico) ?></h5>
                            </div>

                        </div>

                        <hr class="margemDotted">

                        <div class="extraAtivo">
                            <h6><strong>Valor: </strong> <span id="valor">R$ <?= number_format($ativos->valor, 2, ',', '.') ?></span></h6>
                            <h6><strong>Data solicitada: </strong> <?= date('d/m/Y', strtotime($ativos->solicitacao_data)) ?></h6>
                            <h6><strong>Quantidade de dias: </strong> <?= $ativos->quantidade ?> dia(s)</h6>
                        </div>




                    </div>

                <?php endforeach; ?>

            <?php endif; ?>
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