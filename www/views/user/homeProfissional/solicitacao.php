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

            $total_ativos = $total_ativos ?? '';
            $total_pendentes = $total_pendentes ?? '';

            $solicitacaoPendente = $solicitacaoPendente ?? '';

            $usuarios_perfil = $solicitacaoPendente->usuariosImagem ?? '';
            $nome = $solicitacaoPendente->nome ?? '';
            $email = $solicitacaoPendente->email ?? '';
            $telefone = $solicitacaoPendente->telefone ?? '';
            $rua = $solicitacaoPendente->rua  ?? '';
            $complemento = $solicitacaoPendente->complemento ?? '';
            $bairro = $solicitacaoPendente->bairro ?? '';
            $numero = $solicitacaoPendente->numero ?? '';
            $descricao = $solicitacaoPendente->descricao ?? '';
            $cidade = $solicitacaoPendente->cidade ?? '';
            $uf = $solicitacaoPendente ?? '';
            $data_atual = $solicitacaoPendente->solicitacao_data_atual ?? '';
            $data = $solicitacaoPendente->solicitacao_data ?? '';
            $quantidadeDias = $solicitacaoPendente->quantidade ?? '';
            $observacao = $solicitacaoPendente->observacao ?? '';


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

        <div class="voltarPerfil ">
            <a href="<?= base_url('PessoaJuridica/telaPendentes') ?>"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>

        <div class="tituloSolicitacao  mt-2">
            <h3 class="text-center"> <a href=""><i class="bi bi-caret-left-fill"></i></a> Outras solicitações <a href=""><i class="bi bi-caret-right-fill"></i></a></h3>
        </div>

        <div class="solicitacao ">
            <div class="solicitacaoDados">
                <div class="solicitacaoImagem">
                    <img src="<?= base_url($solicitacaoPendente->usuariosImagem) ?>" alt="">
                </div>
                <div class="solicitacaoInfo">
                    <h4><strong><?= esc($solicitacaoPendente->nome) ?></strong></h4>
                    <h5><Strong>Endereço: </Strong><?= esc($solicitacaoPendente->rua) . ' ' . esc($solicitacaoPendente->complemento) . ' Nº ' . esc($solicitacaoPendente->numero) . ' ' . esc($solicitacaoPendente->bairro) . ' ' . esc($solicitacaoPendente->descricao) ?></h5>
                    <h5><strong>Cidade: </strong><?= esc($solicitacaoPendente->cidade) . ' - ' . esc($solicitacaoPendente->uf) ?></h5>
                    <h5><strong>Data de solicitação: </strong> <?= date('d/m/Y', strtotime($solicitacaoPendente->solicitacao_data_atual)) ?></h5>
                    <h5><strong>Data para serviço: </strong> <?= date('d/m/Y', strtotime($solicitacaoPendente->solicitacao_data)) ?></h5>
                    <h5><strong>Dias solicitados: </strong> <?= esc($solicitacaoPendente->quantidade) ?> dia(s)</h5>
                    <h5><strong>Telefone: </strong> <?= $solicitacaoPendente->telefone ?><a href="https://wa.me/<?= $solicitacaoPendente->telefone ?>" style="color: #21c063" target="_blank" rel="nofollow"> <i><i
                                    class="bi bi-whatsapp"></i></i></a>
                    </h5>
                    <h5><strong>Email: </strong> <?= $solicitacaoPendente->email ?> </h5>

                </div>


                <div id="loadingSolicitacao" class="text-center mt-3" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2">Processando...</p>
                </div>



            </div>

            <div class="solicitacaoConfirmar border">

                <div class="solicitacaoTitulo">
                    <h5 class="text-center mt-4 mb-5"><strong>Solicitação de serviço</strong></h5>

                </div>

                <div class="solicitacaoBotao">
                    <button type="button" class="btn-negar" data-bs-target="#modalrecusar" data-bs-dismiss="modal" data-bs-toggle="modal">Recusar</button>
                    <button type="button" class="btn-finalizar btn-processar" data-url="<?= base_url('pessoaJuridica/aceitar/' . $solicitacaoPendente->solicitacao_id) ?>" style="margin-right: 0px !important">Aceitar</button>

                </div>

                <div class="modal fade modal-lg" id="modalrecusar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"> <!--COnteudo com os formulario-->
                                <div class="row">
                                    <h4 class="text-center ">Deseja recusar esse serviço?</h4>
                                    <p class="text-center mt-2 mb-3">Ao recusar esse serviço, você não consiguirá mais ver detalhes dele em sua conta!</p>

                                    <div class="row">
                                        <div id="loadingSolicitacao" class="text-center mt-3" style="display:none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Carregando...</span>
                                            </div>
                                            <p class="mt-2">Processando...</p>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-4">
                                            <label for="solicitacao_motivo">Observação</label>
                                            <textarea name="solicitacao_motivo" class="form-control" placeholder="Descreva o motivo (opcional)" id="solicitacao_motivo">  </textarea>
                                        </div>
                                    </div>


                                    <div class="botaoModalDeletar mt-3">

                                        <button type="button" data-bs-dismiss="modal" class="btn-negar"> Não</button>
                                        <button type="button" class="btn-finalizar btn-processar" data-url="<?= base_url('pessoaJuridica/recusar/' . $solicitacaoPendente->solicitacao_id) ?>"> Sim</button>
                                    </div>



                                </div>


                            </div>

                        </div>
                    </div>
                </div>



            </div>




        </div>

        <div class="solicitacaoObservacao ">
            <h4>Observação</h4>
            <?php if (empty(trim($solicitacaoPendente->observacao))): ?>
                <h5>Não foi informado nenhuma observação!</h5>

            <?php else: ?>
                <p><?= esc($solicitacaoPendente->observacao) ?></p>

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

    <script>
        document.querySelectorAll('.btn-processar').forEach(botao => {

            botao.addEventListener('click', function() {

                document.getElementById('loadingSolicitacao').style.display = 'block';

                this.disabled = true;
                this.innerHTML = 'Processando...';

                setTimeout(() => {
                    window.location.href = this.dataset.url;
                }, 300);

            });

        });
    </script>
    <script src="<?= base_url('Public/Js/timeAlert.js') ?>"></script>

</body>

</html>