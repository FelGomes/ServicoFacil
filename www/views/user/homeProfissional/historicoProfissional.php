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

    <style>
        @media screen and (max-width:768px) {
            .lista-servico {
                display: flex;
                flex-flow: column wrap;
                align-items: flex-start;
            }

        }
    </style>

</head>

<body>
    <header>

        <?php $fotoPerfil = $_SESSION['usuarios_logado']->usuarios_imagem ?? ''; ?>

        <?php if ($_SESSION['usuarios_logado']->pf_tipo == 'Profissional'): ?>

            <?php $nomeUsuario = $_SESSION['usuarios_logado']->pf_nome . ' ' . $_SESSION['usuarios_logado']->pf_sobrenome; ?>



        <?php else: ?>

            <?php $nomeUsuario = $_SESSION['usuarios_logado']->pj_nomeFantasia; ?>


        <?php endif; ?>


        <?php if (isset($_SESSION['msg'])): ?>

            <?php

            echo msg(
                $_SESSION['msg']['texto'],
                $_SESSION['msg']['color'],
            );

            unset($_SESSION['msg']);

            $total_ativos = $total_ativos ?? '';
            $total_pendentes = $total_pendentes ?? '';





            ?>

        <?php endif; ?>


        <div class="topo mt-3">
            <!-- <div class="logo "> -->
            <a href="<?= base_url('user/homeProfissional/index') ?>" class="logo-link navbar-brand"> <img src="<?= base_url('Public/template/Images/Texto do seu parágrafo(3).png') ?>" class="logo" alt="Foto Escolhida"> </a>
            <!-- </div> -->

            <div class="imagem">
                <img src="<?= base_url($fotoPerfil) ?>" alt="Foto Escolhida" data-bs-toggle="offcanvas" data-bs-target="#sidebarPerfil">
            </div>
        </div>

        <nav>
            <ul class="mt-1 mb-5">
                <li><a href="<?= base_url('user/homeProfissional/index') ?>">Home</a></li>
                <li><a href="<?= base_url('user/homeProfissional/historicoProfissional') ?>">Histórico</a></li>
                <li><a href="<?= base_url('pessoaJuridica/avaliacao') ?>">Minhas avaliações</a></li>

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
                    <a class="linksEdicoes" href="<?= base_url('usuario/editProfissional/' . $_SESSION['usuarios_logado']->usuarios_id) ?>"><i class="bi bi-person-plus-fill fs-3"></i> &nbsp; Editar perfil</a>
                    <a class="linksEdicoes" href="<?= base_url('login/logout') ?>"><i class="bi bi-box-arrow-left fs-3"></i> &nbsp; Sair</a>
                </div>


            </div>

        </div>


        <section> <!-- De busca -->
            <div class="container-fluid pt-2">
                <div class="busca mt-2">
                    <h5 class="mt-2">Pesquise por clientes que contrataram seu serviço</h5>
                </div>

                <div class="search mt-2">
                    <div class="col-md-3 mb-4">
                        <input type="search" name="pesquisar" class="form-control" placeholder="Pesquisar por clientes" id="pesquisar">

                    </div>
                </div>

            </div>



        </section>

        <div class="filtrosHistorico">
            <div class="lista">
                <ul class="filtros nav nav-underline" style="margin-left: 40px !important;">
                    <li class="nav-item" style="font-size: 16pt; "> <a class="nav-link" onclick="mostrar('concluidos')" href="#">Concluídos</a></li>
                    <li class="nav-item" style="font-size: 16pt; "> <a class="nav-link" onclick="mostrar('recusados')" href="#">Recusados</a></li>
                </ul>

            </div>

            <!-- <div class="cardBotaoExcluir">
                <button type="button" name="deletar" class="btn-deletar" data-bs-target="#modalDeletar" data-bs-dismiss="modal" data-bs-toggle="modal"> Excluir todos</button>

                <div class="modal fade modal-lg" id="modalDeletar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"> COnteudo com os formulario
                                <form action="" method="post">
                                    <div class="row">
                                        <h4 class="text-center ">Deseja excluir <strong>todo histórico?</strong></h4>
                                        <p class="text-center mt-2 mb-3">Ao deletar todo histórico, você não conseguirá ver seus serviços prestados e cancelados anteriormente! Somente comentários recebidos por serviços anteriores na aba- <strong> <a href="<//?= base_url('pessoaJuridica/avaliacao') ?>">Minhas avaliações.</a></strong> Serviços recusados serão deletados da sua base de dados. </p>


                                        <div class="botaoModalDeletar mt-5">

                                            <button type="button" data-bs-dismiss="modal" class="btn-negar"> Não</button>
                                            <button type="button" class="btn-finalizar">Sim</button>
                                        </div>



                                    </div>

                                </form>


                            </div>

                        </div>
                    </div>
                </div>

            </div> -->
        </div>

        <div class="listaHistorico " id="form-concluidos">
            <?php if (empty($historicoFinalizado)): ?>

                <div style="margin-top: 150px;">

                    <h4 class="text-center"> Não há serviço prestado anteriormente! </h4>
                </div>

            <?php else: ?>
                <?php foreach ($historicoFinalizado as $finalizado): ?>
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?= base_url($finalizado->usuariosImagem) ?>" class="img-card" alt="...">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h4 class="card-title mb-2"><strong><?= esc($finalizado->nome) ?></strong></h4>
                                    <h6><strong>Contato: </strong> <?= esc($finalizado->telefone) ?></h6>
                                    <h6><strong>Data conclusão: </strong> <?= date('d/m/Y', strtotime($finalizado->conclusao)) ?></h6>
                                    <h6><strong>Endereço: </strong> <?= esc($finalizado->endereco) ?></h6>
                                    <h6><strong>Cidade: </strong> <?= esc($finalizado->cidade) ?></h6>
                                    <h6><strong>Valor do serviço: </strong> R$ <?= number_format($finalizado->valor, 2, ',', '.')  ?></h6>

                                    <div class="status">
                                        <p style="font-size: 16pt;">Concluído</p>
                                    </div>

                                    <div class="cardBotao mt-3">
                                        <button type="button" name="deletar" class="btn-deletar" data-bs-target="#modal-<?= $finalizado->solicitacao_id ?>" data-bs-dismiss="modal" data-bs-toggle="modal"> Excluir</button>

                                        <div class="modal fade modal-lg" id="modal-<?= $finalizado->solicitacao_id ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body"> <!--COnteudo com os formulario-->
                                                        <div class="row">
                                                            <h4 class="text-center ">Deseja excluir histórico de: <strong><?= esc($finalizado->nome) ?></strong></h4>
                                                            <p class="text-center mt-2 mb-3">Ao deletar este histórico, você não conseguirá ver mais detalhes referente a esse serviço, somente comentario referente ao mesmo na aba - <strong> <a href="<?= base_url('pessoaJuridica/avaliacao') ?>">Minhas avaliações</a></strong></p>


                                                            <div class="botaoModalDeletar mt-5">

                                                                <button type="button" data-bs-dismiss="modal" class="btn-negar"> Não</button>
                                                                <button type="button" onclick="window.location.href='<?= base_url('historicoProfissional/deletarUnique/' . $finalizado->solicitacao_id) ?>'" class="btn-finalizar">Sim</button>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>


            <?php endif; ?>
        </div>


        <div class="listaHistorico" id="form-recusados" style="display: none;">

            <?php if (empty($historicoRecusado)): ?>

                <div style="margin-top: 150px;">

                    <h4 class="text-center"> Não há serviço recusado anteriormente! </h4>
                </div>



            <?php else: ?>
                <?php foreach ($historicoRecusado as $recusado): ?>
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?= base_url($recusado->usuariosImagem) ?>" class="img-card" alt="...">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h4 class="card-title mb-2"><strong><?= esc($recusado->nome) ?></strong></h4>
                                    <h6><strong>Contato: </strong><?= esc($recusado->telefone) ?></h6>
                                    <h6><strong>Data de solicitação: </strong> <?= esc($recusado->solicitacao_data_atual) ?></h6>
                                    <h6><strong>Endereço: </strong> <?= esc($recusado->endereco) ?></h6>
                                    <h6><strong>Cidade: </strong> <?= esc($recusado->cidade) ?></h6>

                                    <div class="statusR">
                                        <p>Recusado</p>
                                    </div>

                                    <?php if (!empty($recusado->motivo)): ?>
                                        <div class="descricao">
                                            <details>
                                                <summary>Observação</summary>
                                                <p><?= esc($recusado->motivo) ?></p>
                                            </details>
                                        </div>

                                    <?php endif; ?>

                                    <div class="cardBotao mt-3">
                                        <button type="button" name="deletar" class="btn-deletar" data-bs-target="#modal-<?= $recusado->solicitacao_id ?>" data-bs-dismiss="modal" data-bs-toggle="modal"> Excluir</button>


                                        <form action="<?= base_url('historicoProfissional/deletarUnique/' . $recusado->solicitacao_id) ?>">
                                            <div class="modal fade modal-lg" id="modal-<?= $recusado->solicitacao_id ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> <!--COnteudo com os formulario-->
                                                            <div class="row">
                                                                <h4 class="text-center ">Deseja excluir histórico recusado de: <strong>Felipe Ferreira Gomes</strong></h4>
                                                                <p class="text-center mt-2 mb-3">Ao deletar este histórico, você perderá todos os detalhes desta solicitação de serviço </p>


                                                                <div class="botaoModalDeletar mt-5">

                                                                    <button type="button" data-bs-dismiss="modal" class="btn-negar"> Não</button>
                                                                    <button type="submit" class="btn-finalizar">Sim</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
            document.getElementById("form-recusados").style.display = 'none';
            document.getElementById("form-concluidos").style.display = 'none';

            document.getElementById('form-' + tipo).style.display = 'grid';

        }
    </script>


</body>

</html>