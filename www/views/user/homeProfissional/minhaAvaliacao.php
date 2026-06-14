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

        <div class="perfilAvaliacao"> <!--Background gray -->
            <h4 class="mb-4"><strong>Suas Avaliações</strong></h4>

            <?php if (empty($minhasAvaliacao)): ?>

                <div>
                    <p> Não há nenhuma avaliação referente a seu serviço!</p>
                </div>

            <?php else: ?>


                <div class="avaliacaoGroup"> <!--Listagem de avaliacoes -->

                    <?php foreach ($minhasAvaliacao as $avaliacao): ?>
                        <div class="comentGroup border "> <!--Bloco de comentario -->
                            <div class="infoComent "> <!--informaçoes do comentario -->
                                <div class="comentImage">
                                    <img class="Imagecomentario" src="<?= base_url($avaliacao->usuariosImagem) ?>" alt="">
                                </div>
                                <div class="perfilStars infoComentario" >
                                    <h5><?= esc($avaliacao->nome) ?></h5>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>

                                        <?php if ($i <= $avaliacao->nota): ?>
                                            <i class="bi bi-star-fill" style="color: gold;"></i>

                                        <?php else: ?>
                                            <i class="bi bi-star"></i>

                                        <?php endif; ?>

                                    <?php endfor; ?>

                                    <h5 class="mt-3"><strong><?= esc($avaliacao->assunto) ?></strong></h5>
                                    <p><?= esc($avaliacao->descricao) ?></p>

                                    <div class="respostaBox" style="display: none;">
                                        <textarea class="form-control" name="avaliacao_resposta" placeholder="Responder comentário..."></textarea>
                                        <button type="submit" onclick="window.location.href='<?= base_url('pessoaJuridica/responderAvaliacao/' . $avaliacao->avaliacao_id) ?>'" class="btn-solicitacao mt-4">Responder</button>
                                    </div>

                                </div>

                            </div>

                            <div class="dataComentario ">
                                <div class="data">
                                    <p><?= date('d/m/Y', strtotime($avaliacao->avaliacao_data)) ?></p>

                                </div>

                                <!-- <div class="icones disabled">
                                    <i class="bi bi-exclamation-triangle-fill fs-3 disable" style="color: #C52222"></i>
                                    <i class="bi bi-arrow-return-left fs-3" onclick="toggleResposta(this)" style="color: var(--corPrincipal);"></i>


                                </div> -->
                            </div>


                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>



    </main>

    <nav aria-label="...">
        <ul class="pagination pagination-md">
            <li class="page-item active">
                <a class="page-link" aria-current="page">1</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
        </ul>
    </nav>


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
        function toggleResposta(element) {
            const comentario = element.closest('.comentGroup');
            const box = comentario.querySelector('.respostaBox');

            const aberto = box.style.display === 'block';

            document.querySelectorAll('.respostaBox').forEach(b => b.style.display = 'none');

            if (!aberto) {
                box.style.display = 'block';
            }
        }
    </script>


</body>

</html>