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


        <div class="voltarPerfil">
            <a href="<?= base_url('historico/index') ?>"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>

        <div class="tituloSolicitacao mt-2">
            <h3 class="text-center"> <a href=""><i class="bi bi-caret-left-fill"></i></a> Outros Serviços <a href=""><i class="bi bi-caret-right-fill"></i></a></h3>
        </div>

        <div class="solicitacao ">
            <div class="solicitacaoDados">
                <div class="solicitacaoImagem">
                    <img src="<?= base_url($detalhamento->usuariosImagem) ?>" alt="">
                </div>
                <div class="solicitacaoInfo">
                    <h4><strong><?= esc($detalhamento->nome) ?></strong></h4>
                    <h5><strong>Cidade: </strong> <?= esc($detalhamento->cidade) . ' - '  . esc($detalhamento->uf) ?></h5>
                    <h5><strong>Data de solicitação: </strong> <?= date('d/m/Y', strtotime($detalhamento->solicitacao_data_atual)) ?></h5>
                    <h5><strong>Data para serviço: </strong> <?= date('d/m/Y', strtotime($detalhamento->solicitacao_data)) ?></h5>
                    <h5><strong>Data de conclusão: </strong><?= date('d/m/Y', strtotime($detalhamento->solicitacao_conclusao)) ?></h5>
                    <!-- <h5><strong>Dia(s) estrapolado(s): </strong> Se existir</h5> -->

                    <h5><strong>Dias solicitados: </strong> <?= esc($detalhamento->quantidade) ?> dia(s)</h5>
                    <h5><strong>Telefone: </strong> <?= esc($detalhamento->telefone) ?><a href="https://wa.me/<?= esc($detalhamento->telefone) ?>" style="color: #21c063" target="_blank" rel="nofollow"> <i><i
                                    class="bi bi-whatsapp"></i></i></a>
                    </h5>
                    <h5><strong>Email: </strong> <?= esc($detalhamento->email) ?> <a href="" style="color: #000" target="_blank" rel="nofollow"> <i class="bi bi-envelope-at"></i></a></h5>

                </div>


            </div>

            <div class="solicitacaoConfirmar">

                <div class="solicitacaoTitulo">
                    <h5 class="text-center mt-4 mb-5"><strong>Solicitar serviço novamente</strong></h5>

                </div>

                <div class="solicitacaoBotao">
                    <button type="button" class="btn-finalizar" data-bs-target="#modalSolicitarNovamente" data-bs-toggle="modal" style="margin-right: 0px !important">Solicitar</button>

                </div>

                <div class="modal fade modal-lg" id="modalSolicitarNovamente" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Solicitação de serviço</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form action="<?= base_url('historico/enviarSolicitacao') ?>" id="formSolicitacaoNovamente" method="post">
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

                                        <input type="hidden" name="servicos_id" value="<?= $detalhamento->servicos_id ?? '' ?>">
                                        <input type="hidden" name="profissional_id" value="<?= $detalhamento->profissional_id ?? '' ?>">
                                        <input type="hidden" name="solicitacao_id" value="<?= $detalhamento->solicitacao_id ?? '' ?>">


                                        <a href="<?= base_url('usuario/editCliente/' . $_SESSION['usuarios_logado']->usuarios_id) ?>" class="mt-3">Clique aqui para alterar seu endereço</a>

                                        <div id="loadingSolicitacaoNovamente" class="text-center mt-3" style="display:none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Carregando...</span>
                                            </div>
                                            <p class="mt-2">Enviando solicitação...</p>
                                        </div>


                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button class="btn-finalizar" id="btnEnviarNovamente" type="submit">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>




        </div>

        <?php if (!empty($detalhamento->assunto)): ?>
            <div class="solicitacaoObservacao ">
                <h4 class="mb-4"><?= $detalhamento->assunto ?></h4>
                <h5 style="display: flex; justify-content: space-between"><strong> Ótimo Profissional </strong> <span class="text-end small"> Nota: <?= number_format($detalhamento->nota, 1, '.', '') . ' - ' . date('d/m/Y', strtotime($detalhamento->solicitacao_data_atual)) ?></span> </h5>
                <?php if (empty($detalhamento->descricao)): ?>
                    <p> Você não fez nenhuma descrição para este serviço</p>

                <?php else: ?>

                    <p class="text-justify"><?= esc($detalhamento->descricao) ?> </p>


                <?php endif; ?>


                <?php if (!empty($detalhamento->resposta)): ?>
                    <p class="text-justify"><?= $detalhamento->resposta ?></p>

                <?php endif; ?>


                <div class="botaoEditar" style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-finalizar" data-bs-target="#modalEditarComentario" data-bs-toggle="modal" style="width:170px; margin-right: 0px !important; ">Editar Comentário</button>

                    <div class="modal fade modal-lg" id="modalEditarComentario" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Editar comentário</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="<?= base_url('historico/editarAvaliacao') ?>" method="post">
                                    <div class="modal-body"> <!--COnteudo com os formulario-->
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <label for="avaliacao_assunto">Título do Comentário:</label>
                                                <input type="text" id="avaliacao_assunto" class="form-control" name="avaliacao_assunto" placeholder="Ex: Excelente serviço! / Poderia melhorar" required value="<?= esc($detalhamento->assunto) ?>">
                                            </div>


                                            <div class="col-md-12 mt-3 mb-3">
                                                <label for="avaliacao_descricao">Comentários:</label>
                                                <textarea id="avaliacao_descricao" name="avaliacao_descricao" rows="4" class="form-control" placeholder="Conte mais detalhes sobre sua experiência..."> <?= esc($detalhamento->descricao) ?></textarea>
                                            </div>

                                            <input type="hidden" name="avaliacao_id" value="<?= $detalhamento->avaliacao_id ?>">
                                            <input type="hidden" name="cliente_id" value="<?= $detalhamento->cliente_id ?>">
                                            <input type="hidden" name="profissional_id" value="<?= $detalhamento->profissional_id ?>">
                                            <input type="hidden" name="solicitacao_id" value="<?= $detalhamento->solicitacao_id ?>">


                                            <div class="solicitacaoObservacao" style="margin-left: 5px !important;">
                                                <label for="avaliacao_notas">Notas do serviço: &nbsp; &nbsp;</label> <br>
                                                <div class="form-check form-check-inline mb-4">
                                                    <input class="form-check-input" <?= $detalhamento->nota === 1 ? 'checked' : '' ?> type="radio" name="avaliacao_notas" id="inlineRadio1" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" <?= $detalhamento->nota === 2 ? 'checked' : '' ?> type="radio" name="avaliacao_notas" id="inlineRadio2" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" <?= $detalhamento->nota === 3 ? 'checked' : '' ?> type="radio" name="avaliacao_notas" id="inlineRadio3" value="3">
                                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" <?= $detalhamento->nota === 4 ? 'checked' : '' ?> type="radio" name="avaliacao_notas" id="inlineRadio4" value="4">
                                                    <label class="form-check-label" for="inlineRadio3">4</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" <?= $detalhamento->nota === 5 ? 'checked' : '' ?> type="radio" name="avaliacao_notas" id="inlineRadio5" value="5">
                                                    <label class="form-check-label" for="inlineRadio3">5</label>
                                                </div>

                                                <input type="hidden" name="servicos_id" value="<?= $detalhamento->servico_id ?? '' ?>">
                                                <input type="hidden" name="profissional_id" value="<?= $detalhamento->usuarios_id ?? '' ?>">


                                            </div>


                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn-finalizar" type="submit">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <?php else: ?>

            <!-- Realizar comentario -->
            <div class="solicitacaoObservacao ">
                <h4 class="mb-4">Faça um comentário</h4>

                <form action="<?= base_url('historico/avaliarProfissional') ?>" method="post">
                    <label for="avaliacao_notas">Notas do serviço: &nbsp; &nbsp;</label> <br>
                    <div class="form-check form-check-inline mb-4">
                        <input class="form-check-input" type="radio" name="avaliacao_notas" id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="avaliacao_notas" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="avaliacao_notas" id="inlineRadio3" value="3">
                        <label class="form-check-label" for="inlineRadio3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="avaliacao_notas" id="inlineRadio4" value="4">
                        <label class="form-check-label" for="inlineRadio3">4</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input class="form-check-input" type="radio" name="avaliacao_notas" id="inlineRadio5" value="5">
                        <label class="form-check-label" for="inlineRadio3">5</label>
                    </div>

                    <div class="col-md-6">
                        <label for="avaliacao_assunto">Título do Comentário:</label>
                        <input type="text" id="avaliacao_assunto" class="form-control" name="avaliacao_assunto" placeholder="Ex: Excelente serviço! / Poderia melhorar" required>
                    </div>
                    <br>
                    <div class="row">

                        <div class="col-md-12 mt-3 mb-4">
                            <label for="avaliacao_descricao">Comentários:</label>
                            <textarea id="avaliacao_descricao" name="avaliacao_descricao" rows="4" class="form-control" placeholder="Conte mais detalhes sobre sua experiência..."></textarea>
                        </div>

                        <input type="hidden" name="cliente_id" value="<?= $detalhamento->cliente_id ?>">
                        <input type="hidden" name="profissional_id" value="<?= $detalhamento->profissional_id ?>">
                        <input type="hidden" name="solicitacao_id" value="<?= $detalhamento->solicitacao_id ?>">

                    </div>
                    <div class="botaoEditar mb-5" style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn-finalizar" style="width:170px; margin-right: 0px !important; ">Enviar Comentário</button>

                    </div>
                </form>

            </div>

        <?php endif; ?>






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
        document.getElementById('formSolicitacaoNovamente').addEventListener('submit', function() {

            // Mostra o spinner
            document.getElementById('loadingSolicitacaoNovamente').style.display = 'block';

            // Desabilita o botão
            const btn = document.getElementById('btnEnviarNovamente');
            btn.disabled = true;
            btn.innerHTML = 'Enviando...';
        });
    </script>


</body>

</html>