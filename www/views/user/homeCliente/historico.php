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
        .botaoRecusado {
            display: flex;
            justify-content: flex-end;
            margin-right: 120px;
            margin-top: 15px;
        }

        .links {
            display: flex;
            flex-flow: column wrap;
            gap: 5px;
        }

        .linksEdicoes {
            text-decoration: none;
            color: black;
            gap: 5px;

        }

        a.linksEdicoes:hover {
            transform: none !important;
            color: black !important;
            font-weight: normal !important;

        }
    </style>

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


        <section>


            <div id="principal" class="container container-custom border mt-4 mb-5 pb-4">
                <div class="titulo mt-3">
                    <h4 class="text-center">Veja serviços que você contratou</h4>
                    <p class="text-center">Veja os últimos serviços que você solicitou, seus profissionais favoritos e outros status.</p>
                </div>

                <div class="busca-historico mt-5 ">
                    <div class="col-sm">
                        <div class="campo col-md-12">
                            <input type="search" name="buscaHistorico" class="form-control" placeholder="Buscar nome" id="buscaHistorico">

                        </div>


                    </div>

                    <div class="filtros nav nav-underline">
                        <ul>
                            <li class="nav-item"> <a class="nav-link" onclick="mostrar('ultimos')" return false href="#">Últimos</a></li>
                            <!-- <li class="nav-item"> <a class="nav-link" onclick="mostrar('favoritos')" return false href="#">Favoritos</a></li> -->
                            <li class="nav-item"> <a class="nav-link" onclick="mostrar('pendentes')" return false href="#">Pendentes</a></li>
                            <li class="nav-item"> <a class="nav-link" onclick="mostrar('recusados')" return false href="#">Recusados</a></li>
                        </ul>

                    </div>



                </div>


                <!-- listagem de historicos -->
                <div id="form-ultimos">
                    <?php if (empty($servicosFinalizados)): ?>

                        <h4 class="text-center mt-5">Não há nenhum registro de contratação de serviços</h4>

                    <?php else: ?>

                        <?php foreach ($servicosFinalizados as $historicoFinalizado): ?>
                            <div class="lista-historico ">
                                <div class="card-historico">
                                    <div class="info-group">

                                        <div class="info-imagem">
                                            <img src="<?= base_url($historicoFinalizado->usuariosImagem) ?>" alt="">
                                        </div>
                                        <div class="info-dados mt-2">
                                            <h4><?= esc($historicoFinalizado->nome) ?></h4>
                                            <h6><?= esc($historicoFinalizado->servico) ?></h6>
                                            <h5><strong>Data solicitação: </strong><?= esc(date('d/m/Y', strtotime($historicoFinalizado->solicitacao_data))) ?></h5>
                                            <h5><strong>Data de conclusão de serviço: </strong><?= esc(date('d/m/Y', strtotime($historicoFinalizado->solicitacao_conclusao))) ?></h5>

                                            <h5 id="valorServico"><strong>Valor do serviço:</strong> R$ <?= number_format($historicoFinalizado->valor, 2, ',', '.') . ' - ' . esc($historicoFinalizado->cobranca) ?> </h5>

                                        </div>
                                    </div>

                                    <div class="info-status">

                                        <?php if (empty($historicoFinalizado->descricao)): ?>

                                            <h6 class="mt-3" style="font-size: 13pt;">Não foi feito nenhum comentario. Detalha a tela para avaliar esse serviço!</h6>

                                        <?php else: ?>
                                            <div class="info-validation">
                                                <h5><strong>Sua avaliação</strong></h5>

                                            </div>

                                            <div class="detalhes">
                                                <h6 class="text-start"><strong><?= esc($historicoFinalizado->assunto) ?></strong></h6> <!--TIUTLO DO COMENTARIO-->
                                                <p class="text-justify"> <?= mb_strimwidth($historicoFinalizado->descricao, 0, 90, "...") ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <div class="botao" style="margin-top: 80px;">
                                            <i class="bi bi-trash3-fill" onclick="window.location.href='<?= base_url('historico/deletarUnique' . $historicoFinalizado->solicitacao_id) ?>'" id="lixeira"></i>
                                            <button type="submit" class="btn-detalhar" onclick="window.location.href='<?= base_url('historico/detalharServicoFinalizado/' . $historicoFinalizado->solicitacao_id) ?>'">Detalhar</button>

                                        </div>



                                    </div>


                                </div>


                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>


                </div>


                <!-- Listagem de apenas serviços favoritados -->
                <!-- <div id="form-favoritos" style="display: none;">
                    <div class="lista-historico ">

                        <div class="card-historico">
                            <div class="info-group">

                                <div class="info-imagem">
                                    <img src="../../Assets/Images/Academia.jpeg" alt="">
                                </div>
                                <div class="info-dados mt-2">
                                    <h4>João Guilherme Silva</h4>
                                    <h6>Eletricista</h6>
                                    <h5>Data de início: 28/10/2025</h5>
                                    <h5>Data de conclusão: 04/11/2025</h5>

                                    <h5 id="valorServico"><strong>Valor do serviço:</strong> R$200,00</h5>

                                </div>
                            </div>

                            <div class="info-status">
                                <div class="info-validation">
                                    <h5><strong>Sua avaliação</strong></h5>

                                </div>

                                <div class="detalhes">
                                    <h6 class="text-center"><strong>Atendimento Fantástico</strong></h6> --TIUTLO DO COMENTARIO
                                    <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad velit sint itaque quasi aliquid necessitatibus, nostrum aut totam placeat magni perferendis exercitationem dolores, quibusdam quae, saepe numquam voluptatum? In, ipsam?</p>

                                    <div class="botao">
                                        <i class="bi bi-star" id="favorito"></i>
                                        <button class="btn-detalhar">Detalhar</button>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>

                    <div class="lista-historico ">

                        <div class="card-historico">
                            <div class="info-group">

                                <div class="info-imagem">
                                    <img src="../../Assets/Images/Academia.jpeg" alt="">
                                </div>
                                <div class="info-dados mt-2">
                                    <h4>João Guilherme Silva</h4>
                                    <h6>Eletricista</h6>
                                    <h5>Data de início: 28/10/2025</h5>
                                    <h5>Data de conclusão: 04/11/2025</h5>
                                    <h5 id="valorServico"><strong>Valor do serviço:</strong> R$200,00</h5>


                                </div>
                            </div>

                            <div class="info-status">
                                <div class="info-validation">
                                    <h5><strong>Sua avaliação</strong></h5>

                                </div>

                                <div class="detalhes">
                                    <h6 class="text-center"><strong>Atendimento Fantástico</strong></h6> --TIUTLO DO COMENTARIO
                                    <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad velit sint itaque quasi aliquid necessitatibus, nostrum aut totam placeat magni perferendis exercitationem dolores, quibusdam quae, saepe numquam voluptatum? In, ipsam?</p>

                                    <div class="botao">
                                        <i class="bi bi-star" id="favorito"></i>
                                        <button class="btn-detalhar">Detalhar</button>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>

                </div> -->

                <!-- Serviços Pendentes -->
                <div id="form-pendentes" style="display: none;">

                    <?php if (empty($servicosPendentes)): ?>

                        <h4 class="text-center mt-5">Não há nenhum registro de contratação pendente!</h4>

                    <?php else: ?>

                        <?php foreach ($servicosPendentes as $historicoPendente): ?>
                            <div class="lista-historico ">

                                <div class="card-historico">
                                    <div class="info-group">

                                        <div class="info-imagem">
                                            <img src="<?= base_url($historicoPendente->usuariosImagem) ?>" alt="">
                                        </div>
                                        <div class="info-dados mt-2">
                                            <h4><?= esc($historicoPendente->nome) ?></h4>
                                            <h6><?= esc($historicoPendente->servico) ?></h6>
                                            <h5>Data de solicitação: <?= date('d/m/Y', strtotime($historicoPendente->solicitacao_data_atual)) ?></h5>

                                            <h5 id="valorServico"><strong>Status: </strong><span style="color: #F97316; font-weight: bold ">Pendente</span> </h5>

                                        </div>
                                    </div>

                                    <div class="info-status">

                                        <div class="detalhes">
                                            <h6 class="text-center mt-2"><strong>Aviso!</strong></h6> <!--Observação de nao aceitar solicitação-->
                                            <p class="text-justify">Sua solicitação de serviço foi enviado ao profissional, aguarde uma resposta. Caso deseje cancelar a solicitação, clique no botão abaixo!</p>

                                            <div class="botao mt-2">
                                                <button class="btn-pendente mt-2 mb-2" data-bs-target="#modal-<?= $historicoPendente->solicitacao_id ?>" data-bs-dismiss="modal" data-bs-toggle="modal">Cancelar</button>
                                                <form action="<?= base_url('historico/cancelar/' . $historicoPendente->solicitacao_id) ?>" method="post">


                                                    <div class="modal fade modal-lg" id="modal-<?= $historicoPendente->solicitacao_id ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body"> <!--COnteudo com os formulario-->
                                                                    <form action="" method="post">
                                                                        <div class="row">
                                                                            <h4 class="text-center ">Deseja cancelar esta solicitação?</h4>
                                                                            <p class="text-center mt-2 mb-3">Ao cancelar esta solicitação ela desaparecerá para o profissional enviado. Tem certeza? </p>


                                                                            <div class="botaoModalDeletar mt-5">

                                                                                <button type="button" data-bs-dismiss="modal" class="btn-negar"> Não</button>
                                                                                <button type="submit" class="btn-finalizar">Sim</button>
                                                                            </div>



                                                                        </div>

                                                                    </form>


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



                <!-- Serviço recusados -->
                <div id="form-recusados" style="display: none;">

                    <?php if (empty($servicosRecusados)): ?>
                        <h4 class="text-center mt-5">Não há nenhum registro de contratação recusado!</h4>
                    <?php else: ?>
                        <div class="botaoRecusado">

                            <form action="<?= base_url("historico/deletarAll") ?>" method="post">
                                <button type="button" class="btn-deletar mt-2 mb-2" data-bs-target="#modalDeletarTodosHistoricoCliente" data-bs-dismiss="modal" data-bs-toggle="modal">Excluir todos</button>

                                <div class="modal fade modal-lg" id="modalDeletarTodosHistoricoCliente" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body"> <!--COnteudo com os formulario-->
                                                <div class="row">
                                                    <h4 class="text-center ">Deseja excluir todas solicitação recusadas?</h4>
                                                    <p class="text-center mt-2 mb-3">Ao deletar todas as solicitações você não conseguirá ver todas solicitações <strong>Recusadas.</strong> Tem certeza? </p>


                                                    <div class="botaoModalDeletar mt-5">
                                                        <button type="button" class="btn-negar" data-bs-dismiss="modal"> Não</button>

                                                        <button type="submit" onclick="window.location.href='<?= base_url('historico/deletarAll') ?>'" name="deleteAll" class="btn-finalizar">Sim</button>
                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php foreach ($servicosRecusados as $historicoRecusado): ?>
                            <div class="lista-historico ">

                                <div class="card-historico">
                                    <div class="info-group">

                                        <div class="info-imagem">
                                            <img src="<?= base_url($historicoRecusado->usuariosImagem) ?>" alt="">
                                        </div>
                                        <div class="info-dados mt-2">
                                            <h4><?= $historicoRecusado->nome ?></h4>
                                            <h6> <?= $historicoRecusado->servico ?></h6>
                                            <h5>Data de solicitação: <?= date('d/m/Y', strtotime($historicoRecusado->solicitacao_data_atual)) ?></h5>

                                            <h5 id="valorServico"><strong>Status: </strong><span style="color: #C52222; font-weight: bold ">Rescusado</span> </h5>

                                        </div>
                                    </div>

                                    <div class="info-status">


                                        <div class="detalhes">
                                            <h6 class="text-cente"><strong>Observação</strong></h6> <!--Observação de nao aceitar solicitação-->
                                            <?php if (empty($historicoRecusado->motivo)): ?>
                                                <p> Não foi fornecida uma justificativa para esta recusa.</p>

                                            <?php endif; ?>

                                            <p class="text-justify"> <?= $historicoRecusado->motivo ?></p>

                                            <div class="botao mt-2">
                                                <button type="button" class="btn-deletar mt-5 mb-2" data-bs-target="#modal-<?= $historicoRecusado->solicitacao_id ?>" data-bs-dismiss="modal" data-bs-toggle="modal">Excluir</button>

                                                <div class="modal fade modal-lg" id="modal-<?= $historicoRecusado->solicitacao_id ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body"> <!--COnteudo com os formulario-->
                                                                <form action="" method="post">
                                                                    <div class="row">
                                                                        <h4 class="text-center ">Deseja excluir esta solicitação?</h4>
                                                                        <p class="text-center mt-2 mb-3">Ao deletar esta solicitação você perderá todos os detalhes dela. Tem certeza? </p>


                                                                        <div class="botaoModalDeletar mt-5">

                                                                            <button type="button" class="btn-negar" data-bs-dismiss="modal"> Não</button>

                                                                            <button type="submit" onclick="window.location.href='<?= base_url('historico/deletarUnique' . $historicoRecusado->solicitacao_id) ?>'" name="deleteUnique" class="btn-finalizar">Sim</button>
                                                                        </div>



                                                                    </div>

                                                                </form>


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
        const estrela = document.getElementById("favorito");

        estrela.addEventListener("click", () => {
            estrela.classList.toggle("ativo");

            if (estrela.classList.contains("ativo")) {
                estrela.classList.remove("bi-star");
                estrela.classList.add("bi-star-fill");
            } else {
                estrela.classList.remove("bi-star-fill");
                estrela.classList.add("bi-star");
            }
        });

        function mostrar(tipo) {
            document.getElementById("form-ultimos").style.display = 'none';
            // document.getElementById("form-favoritos").style.display = 'none';
            document.getElementById("form-recusados").style.display = 'none';
            document.getElementById("form-pendentes").style.display = 'none';

            document.getElementById('form-' + tipo).style.display = 'block';

        }
    </script>



</body>

</html>