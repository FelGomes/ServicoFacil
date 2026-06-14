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

        <?php if ($_SESSION['usuarios_logado']->pf_tipo == 'Cliente'): ?>

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



        <!-- Dados do sistema -->
        <?php
        // Se o seu Controller passou no $data['dadosProfissional'], o extract() criou a variável $dadosProfissional
        $nome = $dadosProfissional->nome ?? '';
        $cidade = $dadosProfissional->cidade ?? '';
        $uf = $dadosProfissional->uf ?? '';
        $celular = $dadosProfissional->telefone ?? '';
        $email = $dadosProfissional->email ?? '';
        $fotoPessoa = $dadosProfissional->fotoPerfil ?? '';
        $mediaAvaliacao = $dadosProfissional->mediaAvaliacao ?? 0.0;
        $totalAvaliacao = $dadosProfissional->totalAvaliacoes ?? '';
        $descricao = $dadosProfissional->descricao ?? '';
        $servicoNome = $dadosProfissional->servico ?? '';
        $servicoData = $dadosProfissional->atendimento ?? '';
        $servicoValor = $dadosProfissional->valor ?? 0.0;
        $servicoCobranca = $dadosProfissional->cobranca ?? '';
        $servicoExperiencia = $dadosProfissional->experiencia ?? '';
        $servico_id = $dadosProfissional->servicos_id ?? '';
        ?>


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




        <div class="voltarPerfil  ">
            <a href="<?= base_url('user/homeCliente/index') ?>"><i class="bi bi-arrow-left"></i> Voltar</a>

        </div>

        <hr class="margem">

        <div class="perfilCliente"> <!--Borda cinza-->
            <div class="perfilDados"> <!--Borda vermelha-->
                <div class="perfilName"> <!--Borda Azul-->
                    <h3><?= $nome ?></h3>
                    <p><?= $cidade . ' - ' . $uf ?></p>
                    <p><strong>Contato: </strong> <?= $celular ?></p>
                    <p><strong>Email: </strong> <?= $email ?></p>
                </div>

                <div class="perfilDetalhes"> <!--Borda verde-->
                    <div class="perfilImagem"> <!--Borda azul -->
                        <img src="<?= base_url($fotoPessoa) ?>" alt="FOTOPERFIL">
                    </div>
                    <div class="perfilNotas">
                        <div class="perfilStars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>

                                <?php if ($i <= $mediaAvaliacao): ?>
                                    <i class="bi bi-star-fill fs-5" style="color: gold;"></i>

                                <?php else: ?>
                                    <i class="bi bi-star fs-5"></i>

                                <?php endif; ?>

                            <?php endfor; ?>
                            <p> (<?= number_format($mediaAvaliacao, 1, '.', ',') ?>) &nbsp; <?= $totalAvaliacao ?></p>

                        </div>

                        <h5 class="mb-3"><strong><?= $servicoNome ?> - </strong> <?= $servicoData ?> </h5>




                        <h4>Sobre</h4>
                        <p><?= esc($servicoExperiencia . ' ' . mb_strimwidth($descricao, 0, 190, "...")); ?></p>

                    </div>


                </div>

            </div>
            <div class="perfiServico">
                <h5>Serviço</h5>
                <h6>R$: <?= esc(number_format($servicoValor, '2', ',', '.') . ' - ' . $servicoCobranca) ?> </h6>

                <button type="button" class="btn-finalizar mt-5" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Solicitar</button>


                <div class="modal fade modal-lg" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Solicitação de serviço</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form action="<?= base_url('pessoaFisica/enviarSolicitacao') ?>" id="formSolicitacao" method="post">
                                <div class="modal-body"> <!--COnteudo com os formulario-->
                                    <div class="row">

                                        <div class="col-md-12">
                                            <label for="solicitacao_data">Data de solicitação</label>
                                            <input type="date" name="solicitacao_data" class="form-control" placeholder="Data para o serviço" id="solicitacao_data" value="<?= $_POST['solicitacao_data'] ?? '' ?>" required>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="solicitacao_quantidade">Quantidade de dias para serviço</label>
                                            <input type="number" name="solicitacao_quantidade" class="form-control" placeholder="Quantidade de dias para o serviço" id="solicitacao_quantidade" value="<?= $_POST['solicitacao_quantidade'] ?? '' ?>" required>
                                        </div>


                                        <div class="col-md-12 mb-3 mt-3">
                                            <label for="solicitacao_observacao">Observação</label>
                                            <textarea name="solicitacao_observacao" class="form-control" placeholder="Observação do serviço" id="solicitacao_observacao">

                                            </textarea>
                                        </div>

                                        <input type="hidden" name="servicos_id" value="<?= $servico_id ?? '' ?>">
                                        <input type="hidden" name="profissional_id" value="<?= $dadosProfissional->usuarios_id ?? '' ?>">


                                        <a href="<?= base_url('usuario/editCliente/' . $_SESSION['usuarios_logado']->usuarios_id) ?>" class="mt-3">Clique aqui para alterar seu endereço</a>

                                        <div id="loadingSolicitacao" class="text-center mt-3" style="display:none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Carregando...</span>
                                            </div>
                                            <p class="mt-2">Enviando solicitação...</p>
                                        </div>


                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button class="btn-finalizar" id="btnEnviar" type="submit">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>



        </div>


        <div class="perfilAvaliacao"> <!--Background gray -->
            <h4>Avaliações</h4>

            <?php if (empty($comentarios)): ?>

                <h4 class="text-center">Esse profissional não possui avaliações no momento!</h4>

            <?php else: ?>


                <div class="avaliacaoGroup"> <!--Listagem de avaliacoes -->
                    <?php foreach ($comentarios as $comentario): ?>

                        <div class="comentGroup"> <!--Bloco de comentario -->
                            <div class="infoComent"> <!--informaçoes do comentario -->
                                <div class="comentImage">
                                    <img class="Imagecomentario" src="<?= base_url($comentario->imagem) ?>" alt="">

                                </div>
                                <div class="perfilStars infoComentario">
                                    <h5><?= esc($comentario->nome) ?></h5>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>

                                        <?php if ($i <= $mediaAvaliacao): ?>
                                            <i class="bi bi-star-fill fs-5" style="color: gold;"></i>

                                        <?php else: ?>
                                            <i class="bi bi-star fs-5"></i>

                                        <?php endif; ?>

                                    <?php endfor; ?>

                                    <h5 class="mt-3"><strong><?= esc($comentario->assunto) ?></strong></h5>
                                    <p><?= esc($comentario->descricao) ?> </p>

                                </div>

                            </div>

                            <div class="dataComentario">
                                <p><?= date('d/m/Y', strtotime($comentario->data)) ?></p>
                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>





                </div>

        </div>



    </main>

    <?php if (empty($comentarios)): ?>


    <?php else: ?>


        <nav aria-label="...">
            <ul class="pagination pagination-md">
                <li class="page-item active">
                    <a class="page-link" aria-current="page">1</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </nav>

    <?php endif; ?>



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

    <script>
        document.getElementById('formSolicitacao').addEventListener('submit', function() {

            // Mostra o spinner
            document.getElementById('loadingSolicitacao').style.display = 'block';

            // Desabilita o botão
            const btn = document.getElementById('btnEnviar');
            btn.disabled = true;
            btn.innerHTML = 'Enviando...';
        });
    </script>


</body>

</html>