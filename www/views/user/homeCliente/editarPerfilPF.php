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
                    <a class="linksEdicoes" href=""><i class="bi bi-person-plus-fill fs-3"></i> &nbsp; Editar perfil</a>
                    <a class="linksEdicoes" href="<?= base_url('login/logout') ?>"><i class="bi bi-box-arrow-left fs-3"></i> &nbsp; Sair</a>
                </div>


            </div>

        </div>


        <section>


            <div id="principal" class="container container-custom border mt-4 mb-5 pb-4">

                <form action="<?= base_url('usuario/AlterarDados/' . $pessoaFisica->usuarios_id) ?>" method="post" enctype="multipart/form-data"> <!--Formulario para enviou de validação de dados -->

                    <div id="form-dadosPessoais">
                        <div class="row">
                            <h4 class="text-center mt-3">Editar Perfil</h4>
                            <div class="fotoPerfilEdit">
                                <div class="infoDados">
                                    <div class="editPerfil">
                                        <img class="text-center" id="previewImagem" value="<?= $_POST['usuarios_imagem'] ?? '' ?>" src="<?= base_url($pessoaFisica->usuarios_imagem) ?>" alt="">

                                    </div>
                                    <div class="buttonPerfil">

                                        <input type="file" name="usuarios_imagem" id="usuarios_imagem" accept="image/*" value="Alterar Foto">
                                    </div>
                                </div>


                            </div>

                            <div class="filtros nav nav-underline">
                                <ul>
                                    <li class="nav-item"> <a class="nav-link" onclick="mostrar('dadosPessoais')" return false href="#">Dados Pessoais</a></li>
                                    <li class="nav-item"> <a class="nav-link" onclick="mostrar('endereco')" return false href="#">Endereço</a></li>
                                </ul>

                            </div>

                            <!-- Cadastro de pessoa fisica -->
                            <h5 class="text-start"> <i class="bi bi-person-fill fs-3 "></i> Dados Pessoais</h5>
                            <div class="row">

                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="pf_nome">Nome </label>
                                    <input type="text" name="pf_nome" id="pf_nome" placeholder="Digite seu primeiro nome" class="form-control" value="<?= $pessoaFisica->pf_nome ?>">
                                </div>

                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="pf_sobrenome">Sobrenome </label>
                                    <input type="text" name="pf_sobrenome" id="pf_sobrenome" placeholder="Digite seu sobrenome" class="form-control" value="<?= $pessoaFisica->pf_sobrenome ?>">
                                </div>

                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="pf_dataNascimento">Data de nascimento </label>
                                    <input type="date" name="pf_dataNascimento" id="pf_dataNascimento" class="form-control" value="<?= $pessoaFisica->pf_dataNascimento ?>">
                                </div>


                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="pf_genero">Gênero</label>
                                    <select name="pf_genero" class="form-control" value="<?= $_POST['pf_genero'] ?? '' ?>" id="pf_genero">
                                        <option selected>Selecione seu gênero</option>
                                        <option value="Masculino" <?= $pessoaFisica->pf_genero === 'Masculino' ? 'Selected' : '' ?>>Masculino</option>
                                        <option value="Feminino" <?= $pessoaFisica->pf_genero === 'Feminino' ? 'Selected' : '' ?>> Feminino</option>
                                        <option value="Outro" <?= $pessoaFisica->pf_genero === 'Outro' ? 'Selected' : '' ?>> Outro</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="usuarios_telefone">Telefone/Celular</label>
                                    <input type="tel" name="usuarios_telefone" id="usuarios_telefone_pf" placeholder="Digite seu telefone" class="form-control tel" value="<?= $pessoaFisica->usuarios_telefone ?>">
                                </div>




                            </div>

                            <div class="botoes col-md-6 ms-auto mt-5 mb-4">
                                <button type="button" class="btn-deletar" data-bs-target="#modalDeletarTodosHistoricoCliente" data-bs-dismiss="modal" data-bs-toggle="modal">Desativar </button>

                                <div class="modal fade modal-lg" id="modalDeletarTodosHistoricoCliente" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body"> <!--COnteudo com os formulario-->
                                                <div class="row">
                                                    <h4 class="text-center ">Deseja desativar <strong>sua conta?</strong></h4>
                                                    <p class="text-center mt-2 mb-3">Ao desativar sua conta, você perderá o acesso ao sistema. Ela só poderá ser reativada por um administrador. Tem certeza de que deseja continuar? </p>


                                                    <div class="botaoModalDeletar mt-5">
                                                        <button type="button" class="btn-negar" data-bs-dismiss="modal"> Não</button>

                                                        <button type="button" onclick="window.location.href='<?= base_url('usuario/DesativarConta/' . $pessoaFisica->usuarios_id) ?>'" name="deleteAll" class="btn-finalizar">Sim</button>
                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn-finalizar">Editar</button>
                            </div>


                        </div>
                    </div>
                    <!-- Fim da pessoa -->

                    <div id="form-endereco" style="display:none" class="cold-md-12 mt-4">

                        <div class="filtros nav nav-underline">
                            <ul>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('dadosPessoais')" return false href="#">Dados Pessoais</a></li>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('endereco')" return false href="#">Endereço</a></li>
                            </ul>

                        </div>

                        <h5 class="text-start mt-5 "><i class="bi bi-house-fill fs-3"></i> Endereço</h5>
                        <div class="row">
                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_rua">Rua/Logradouro </label>
                                <input type="text" name="endereco_rua" id="endereco_rua" placeholder="Digite sua rua" class="form-control" value="<?= $pessoaFisica->endereco_rua ?>" ?>
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_bairro">Bairro </label>
                                <input type="text" name="endereco_bairro" id="endereco_bairro" placeholder="Digite seu bairro" class="form-control" required value="<?= $pessoaFisica->endereco_bairro ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_complemento">Complemento </label>
                                <input type="text" name="endereco_complemento" id="endereco_complemento" placeholder="Apto, Bloco, Quadra, Etc..." class="form-control" value="<?= $pessoaFisica->endereco_complemento ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_numero">Número </label>
                                <input type="text" name="endereco_numero" id="endereco_numero" placeholder="Número da residência" class="form-control" required value="<?= $pessoaFisica->endereco_numero ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_cep">CEP </label>
                                <input type="text" name="endereco_cep" id="endereco_cep" placeholder="Informe o CEP" class="form-control" value="<?= $pessoaFisica->endereco_cep ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_nome">Titulo endereco </label>
                                <input type="text" name="endereco_nome" id="endereco_nome" placeholder="Ex. Minha loja" class="form-control" required value="<?= $pessoaFisica->endereco_nome ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_cidade">Cidade </label>
                                <input type="text" name="endereco_cidade" id="endereco_cidade" placeholder="Digite sua cidade" class="form-control" required value="<?= $pessoaFisica->endereco_cidade ?>">
                            </div>

                            <?php
                            $ufs = [
                                'AC',
                                'AL',
                                'AP',
                                'AM',
                                'BA',
                                'CE',
                                'DF',
                                'ES',
                                'GO',
                                'MA',
                                'MT',
                                'MS',
                                'MG',
                                'PA',
                                'PB',
                                'PR',
                                'PE',
                                'PI',
                                'RJ',
                                'RN',
                                'RS',
                                'RO',
                                'RR',
                                'SC',
                                'SP',
                                'SE',
                                'TO'
                            ];
                            ?>


                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_uf">UF</label>
                                <select name="endereco_uf" class="form-control" id="endereco_uf" value="<?= $_POST['endereco_uf'] ?? '' ?>">
                                    <?php foreach ($ufs as $uf): ?>

                                        <option value="<?= $uf ?>" <?= $pessoaFisica->endereco_uf == $uf ? 'selected' : '' ?>>
                                            <?= $uf ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="col-md-12 mt-4 mb-2">
                                <label for="endereco_descricao">Descrição</label>
                                <textarea name="endereco_descricao" id="endereco_descricao" placeholder="Descreva a localização (opcional)" class="form-control"><?= $pessoaFisica->endereco_descricao ?></textarea>

                            </div>


                        </div>
                        <div class="botoes col-md-6 ms-auto mt-5 mb-4">
                            <button type="button" class="btn-deletar" data-bs-target="#modalDeletarTodosHistoricoCliente" data-bs-dismiss="modal" data-bs-toggle="modal">Desativar </button>

                            <div class="modal fade modal-lg" id="modalDeletarTodosHistoricoCliente" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"> <!--COnteudo com os formulario-->
                                            <div class="row">
                                                <h4 class="text-center ">Deseja desativar <strong>sua conta?</strong></h4>
                                                <p class="text-center mt-2 mb-3">Ao desativar sua conta, você perderá o acesso ao sistema. Ela só poderá ser reativada por um administrador. Tem certeza de que deseja continuar? </p>


                                                <div class="botaoModalDeletar mt-5">
                                                    <button type="button" class="btn-negar" data-bs-dismiss="modal"> Não</button>

                                                    <button type="submit" onclick="window.location.href='<?= base_url('usuario/DesativarConta') ?>'" name="deleteAll" class="btn-finalizar">Sim</button>
                                                </div>



                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-finalizar">Editar</button>
                        </div>
                    </div>


                </form>
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
            document.getElementById("form-dadosPessoais").style.display = 'none';
            document.getElementById("form-endereco").style.display = 'none';

            document.getElementById('form-' + tipo).style.display = 'block';

        }
    </script>

    <script>
        document.getElementById('usuarios_imagem').addEventListener('change', function(event) {

            const arquivo = event.target.files[0];

            if (!arquivo) {
                return;
            }

            const leitor = new FileReader();

            leitor.onload = function(e) {
                document.getElementById('previewImagem').src = e.target.result;
            }

            leitor.readAsDataURL(arquivo);
        });
    </script>



</body>

</html>