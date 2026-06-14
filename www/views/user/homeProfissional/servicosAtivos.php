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

        <div id="principal" class="container container-custom border mt-4 mb-5 pb-4">
            <h3 class="text-center mt-4"> <a href="<?= base_url('PessoaJuridica/telaPendentes') ?>" class="mt-2"><i class="bi bi-caret-left-fill"></i></a> &nbsp; Serviços Ativos</h3>

            <?php if (empty($solicitacaoAtivas)): ?>

                <div style="margin-top: 150px;">

                    <h4 class="text-center"> Não há nenhuma solicitação de serviço ativo! </h4>
                </div>


            <?php else: ?>

                <div class="finalizarServico mt-3">
                    <button type="button" class="btn-finalizar" data-bs-target="#modalFinalizar" data-bs-dismiss="modal" data-bs-toggle="modal">Finalizar Serviço</button>

                    <div class="modal fade modal-lg" id="modalFinalizar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body"> <!--COnteudo com os formulario-->
                                    <div class="row">
                                        <form action="" method="post">
                                            <h4 class="text-center ">Deseja finalizar todos o serviços? </h4>
                                            <p class="text-center mt-2 mb-5">Ao finalizar todos os serviços não será possível visualizar nessa aba novamente. Todos estarão disponível na página de histórico!</p>

                                            <div class="botaoModalDeletar mt-3">

                                                <button type="button" data-bs-dismiss="modal" class="btn-negar"> Não</button>
                                                <button type="button" onclick="window.location.href='<?= base_url('pessoaJuridica/finalizarAll') ?>'" class="btn-finalizar">Sim</button>
                                            </div>

                                        </form>



                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>



                </div>

            <?php endif; ?>

            <div class="lista-servicoAtivo">

                <?php foreach ($solicitacaoAtivas as $ativos): ?>
                    <div class="ativoGroup p-3">
                        <div class="ativoInfo">
                            <img src="<?= base_url($ativos->usuariosImagem) ?>" alt="FotoDePerfilDoUsuario">
                            <div class="ativoDados">
                                <h4 class="mb-3"><?= esc($ativos->nome) ?></h4>
                                <h6><strong>Data da solicitaçao: </strong> <?= date('d/m/Y', strtotime($ativos->solicitacao_data_atual))  ?></h6>
                                <h6><strong>Data para serviço:</strong> <?= date('d/m/Y', strtotime($ativos->solicitacao_data)) ?></h6>
                                <h6><strong>Quantidade de dias:</strong> <?= $ativos->quantidade ?> dia(s)</h6>

                            </div>
                        </div>

                        <div class="ativoDetalhes">

                            <button type="button" data-bs-target="#modal-<?= $ativos->solicitacao_id ?>" data-bs-toggle="modal" class="btn-solicitacao">Mais</button>

                            <div class="modal fade modal-xl" id="modal-<?= $ativos->solicitacao_id ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"> <!--COnteudo com os formulario-->
                                            <h3 class="text-center mb-5"> <a href=""><i class="bi bi-caret-left-fill"></i></a> &nbsp; <strong>Clientes</strong> &nbsp; <a href=""><i class="bi bi-caret-right-fill"></i></a></h3>

                                            <div class="modalAtivoInfo mb-2">
                                                <div class="modalAtivoDetalhes">
                                                    <div class="modalImagem">
                                                        <img src="<?= base_url($ativos->usuariosImagem) ?>" alt="">
                                                    </div>

                                                    <div class="modalDados">
                                                        <h4><strong><?= esc($ativos->nome) ?></strong></h4>
                                                        <h6><strong>Endereco: </strong> <?= esc($ativos->rua) . ' ' . esc($ativos->complemento) . ' Nº ' . esc($ativos->numero) . ' ' . esc($ativos->bairro) . ' - ' . esc($ativos->cidade) . ' - ' . esc($ativos->uf) . ' ' . esc($ativos->descricao) ?></h6>
                                                        <h6><strong>Email: </strong> <?= esc($ativos->email) ?></h6>
                                                        <h6><strong>Celular: </strong> <?= esc($ativos->telefone) ?></h6>
                                                        <h6><strong>Data da solicitaçao: </strong> <?= date('d/m/Y', strtotime($ativos->solicitacao_data_atual))  ?></h6>
                                                        <h6><strong>Data para serviço:</strong> <?= date('d/m/Y', strtotime($ativos->solicitacao_data)) ?></h6>
                                                        <h6><strong>Quantidade de dias:</strong> <?= $ativos->quantidade ?> dia(s)</h6>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="modalObservacao mt-3">
                                                <h4 class="text-start"><strong>Observação</strong></h4>
                                                <?php if (empty(trim($ativos->observacao))): ?>
                                                    <h6>Não há nenhuma observação referente a esse serviço</h6>
                                                <?php else: ?>
                                                    <p><?= esc($ativos->observacao) ?></p>
                                                <?php endif; ?>
                                            </div>





                                            <div class="modal-footer mt-2">
                                                <div class="botaoServicoAtivo">

                                                    <button type="button" name="finalizarServico" data-bs-target="#modalConfirmar" data-bs-dismiss="modal" data-bs-toggle="modal" onclick="window.location.href='<?= base_url('pessoaJuridica/finalizarUnique/' . $ativos->solicitacao_id) ?>'" class="btn-finalizarSerivo">Finalizar Serviço</button>



                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>

                            <form action="" method="post">
                                <div class="modal fade modal-lg" id="modalConfirmar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body"> <!--COnteudo com os formulario-->
                                                <div class="row">
                                                    <h4 class="text-center ">Deseja finalizar esse serviço?</h4>
                                                    <p class="text-center mt-2 mb-5">Este serviço será removido da lista de ativos e ficará disponível apenas no histórico.</p>

                                                    <div class="botaoModalDeletar mt-3">

                                                        <button type="button" data-bs-dismiss="modal" class="btn-negar"> Não</button>
                                                        <button type="button" class="btn-finalizar">Sim</button>
                                                    </div>



                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>




                    </div>

                <?php endforeach; ?>
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