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


        <section>


            <div id="principal" class="container container-custom border mt-4 mb-5 pb-4">

                <form action="<?= base_url('usuario/AlterarDadosProfissionalPJ/' . $pessoaJuridica->usuarios_id) ?>" method="post" enctype="multipart/form-data"> <!--Formulario para enviou de validação de dados -->

                    <div id="form-dadosPessoais">
                        <div class="row">
                            <h4 class="text-center mt-3">Editar Perfil</h4>
                            <div class="fotoPerfilEdit">
                                <div class="infoDados">
                                    <div class="editPerfil">
                                        <img class="text-center" id="previewImagem" value="<?= $_POST['usuarios_imagem'] ?? '' ?>" src="<?= base_url($pessoaJuridica->usuarios_imagem) ?>" alt="">

                                    </div>
                                    <div class="buttonPerfil">

                                        <input type="file" name="usuarios_imagem" id="usuarios_imagem" accept="image/*" value="Alterar Foto">
                                    </div>
                                </div>


                            </div>

                            <div class="filtros nav nav-underline">
                                <ul>
                                    <li class="nav-item"> <a class="nav-link" onclick="mostrar('dadosPessoais')" return false href="#">Dados Pessoais</a></li>
                                    <li class="nav-item"> <a class="nav-link" onclick="mostrar('endereco')" return false href="#">E</a></li>
                                    <li class="nav-item"> <a class="nav-link" onclick="mostrar('servico')" return false href="#">Serviços</a></li>
                                </ul>


                            </div>

                            <!-- Cadastro de pessoa fisica -->
                            <h5 class="text-start"> <i class="bi bi-building-fill fs-3"></i> Dados Empresarial</h5>
                            <div class="row">

                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="pj_razaoSocial">Razao social </label>
                                    <input type="text" name="pj_razaoSocial" id="pj_razaoSocial" placeholder="Digite a razao social" class="form-control" value="<?= $pessoaJuridica->pj_razaoSocial ?>">
                                </div>

                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="pj_nomeFantasia">Nome Fantasia </label>
                                    <input type="text" name="pj_nomeFantasia" id="pj_nomeFantasia" placeholder="Digite o nome fantasia" class="form-control" value="<?= $pessoaJuridica->pj_nomeFantasia ?>">
                                </div>

                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="pj_dataFundacao">Data de fundação </label>
                                    <input type="date" name="pj_dataFundacao" id="pj_dataFundacao" class="form-control" value="<?= $pessoaJuridica->pj_dataFundacao ?>">
                                </div>


                                <div class="col-md-6 mt-4 mb-2">
                                    <label for="usuarios_telefone">Telefone/Celular</label>
                                    <input type="tel" name="usuarios_telefone" id="usuarios_telefone_pj" placeholder="Digite seu telefone" class="form-control tel" value="<?= $pessoaJuridica->usuarios_telefone ?>">
                                </div>




                            </div>




                        </div>
                    </div>
                    <!-- Fim da pessoa -->

                    <div id="form-endereco" style="display:none" class="cold-md-12 mt-4">

                        <div class="filtros nav nav-underline">
                            <ul>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('dadosPessoais')" return false href="#">Dados Pessoais</a></li>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('endereco')" return false href="#">Endereço</a></li>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('servico')" return false href="#">Serviços</a></li>
                            </ul>

                        </div>

                        <h5 class="text-start mt-5 "><i class="bi bi-house-fill fs-3"></i> Endereço</h5>
                        <div class="row">
                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_rua">Rua/Logradouro </label>
                                <input type="text" name="endereco_rua" id="endereco_rua" placeholder="Digite sua rua" class="form-control" value="<?= $pessoaJuridica->endereco_rua ?>" ?>
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_bairro">Bairro </label>
                                <input type="text" name="endereco_bairro" id="endereco_bairro" placeholder="Digite seu bairro" class="form-control" value="<?= $pessoaJuridica->endereco_bairro ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_complemento">Complemento </label>
                                <input type="text" name="endereco_complemento" id="endereco_complemento" placeholder="Apto, Bloco, Quadra, Etc..." class="form-control" value="<?= $pessoaJuridica->endereco_complemento ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_numero">Número </label>
                                <input type="text" name="endereco_numero" id="endereco_numero" placeholder="Número da residência" class="form-control" value="<?= $pessoaJuridica->endereco_numero ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_cep">CEP </label>
                                <input type="text" name="endereco_cep" id="endereco_cep" placeholder="Informe o CEP" class="form-control" value="<?= $pessoaJuridica->endereco_cep ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_nome">Titulo endereco </label>
                                <input type="text" name="endereco_nome" id="endereco_nome" placeholder="Ex. Minha loja" class="form-control" value="<?= $pessoaJuridica->endereco_nome ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_cidade">Cidade </label>
                                <input type="text" name="endereco_cidade" id="endereco_cidade" placeholder="Digite sua cidade" class="form-control" value="<?= $pessoaJuridica->endereco_cidade ?>">
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

                                        <option value="<?= $uf ?>" <?= $pessoaJuridica->endereco_uf == $uf ? 'selected' : '' ?>>
                                            <?= $uf ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="col-md-12 mt-4 mb-2">
                                <label for="endereco_descricao">Descrição</label>
                                <textarea name="endereco_descricao" id="endereco_descricao" placeholder="Descreva a localização (opcional)" class="form-control"><?= $pessoaJuridica->endereco_descricao ?></textarea>

                            </div>


                        </div>

                    </div>


                    <!-- Servicos -->
                    <div id="form-servico" style="display:none" class="cold-md-12 mt-4">

                        <div class="filtros nav nav-underline">
                            <ul>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('dadosPessoais')" return false href="#">Dados Pessoais</a></li>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('endereco')" return false href="#">Endereço</a></li>
                                <li class="nav-item"> <a class="nav-link" onclick="mostrar('servico')" return false href="#">Serviços</a></li>
                            </ul>

                        </div>

                        <h5 class="text-start mt-5 "><i class="bi bi-wrench-adjustable"></i> Endereço</h5>
                        <div class="row">

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="servicos_nome">Tipo de serviço </label>
                                <input type="text" name="servicos_nome" id="servicos_nome" placeholder="Informe o tipo de serviço" class="form-control" required value="<?= $pessoaJuridica->servicos_nome ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="servicos_data">Dias de serviço</label>
                                <select name="servicos_data" class="form-control" id="data">
                                    <option selected>Selecione</option>
                                    <option value="Segunda à Sexta" <?= $pessoaJuridica->servicos_data == 'Segunda à Sexta' ? 'Selected' : '' ?>>Seg. à Sexta</option>
                                    <option value="Segunda à Sabado" <?= $pessoaJuridica->servicos_data == "Segunda à Sabado" ? 'Selected' : '' ?>>Seg. à Sábado</option>
                                    <option value="Todos os dias" <?= $pessoaJuridica->servicos_data == "Todos os dias" ? 'Selected' : '' ?>>Todos os dias</option>
                                    <option value="Fins de Semana" <?= $pessoaJuridica->servicos_data == "Fins de Semana" ? 'Selected' : '' ?>>Fins de Semana</option>
                                    <option value="Dias Intercalados" <?= $pessoaJuridica->servicos_data == "Dias Intercalados" ? 'Selected' : '' ?>>Dias intercalados</option>
                                </select>
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="servicos_valor">Valor do atendimento </label>
                                <input type="number" name="servicos_valor" placeholder="Informe o valor do seu serviço" id="servicos_valor" class="form-control" step="0.01" min="0.01" required value="<?= $pessoaJuridica->servicos_valor ?>">
                            </div>


                            <div class="col-md-6 mt-4 mb-2">
                                <label for="servicos_tipo_cobranca">Tipo de cobrança</label>
                                <select name="servicos_tipo_cobranca" class="form-control" id="servicos_tipo_cobranca" value="<?= $post['servicos_tipo_cobrança'] ?? '' ?>">
                                    <option value="" disabled>Selecione a cobrança</option>
                                    <option value="Hora" <?= $pessoaJuridica->servicos_tipo_cobranca == "Todos os dias" ? 'Selected' : '' ?>>Por hora</option>
                                    <option value="Dia" <?= $pessoaJuridica->servicos_tipo_cobranca == "Dia" ? 'Selected' : '' ?>>Por dia</option>
                                    <option value="Total" <?= $pessoaJuridica->servicos_tipo_cobranca == "Total" ? 'Selected' : '' ?>>Serviço total</option>
                                    <option value="Negociar" <?= $pessoaJuridica->servicos_tipo_cobranca == "Negociar" ? 'Selected' : '' ?>>A negociar</option>

                                </select>
                            </div>


                            <div class="col-md-12 mt-4 mb-2">
                                <label for="servicos_nivel_experiencia">Nível de experiência</label>
                                <select name="servicos_nivel_experiencia" class="form-control" id="servicos_nivel_experiencia">
                                    <option selected>Selecione o nível de experiência</option>
                                    <option value="Inciante" <?= $pessoaJuridica->servicos_nivel_experiencia == "Inciante" ? 'Selected' : '' ?>>Inciante</option>
                                    <option value="Intermediário" <?= $pessoaJuridica->servicos_nivel_experiencia == "Intermediário" ? 'Selected' : '' ?>>Intermediário</option>
                                    <option value="Avançado" <?= $pessoaJuridica->servicos_nivel_experiencia == "Avançado" ? 'Selected' : '' ?>> Avançado</option>
                                </select>

                            </div>

                            <div class="col-md-12 mt-4 mb-5">
                                <label for="servicos_descricao">Descrição</label>
                                <textarea name="servicos_descricao" placeholder="Descreva mais sobre seu serviço" class="form-control h-1200px" id="servicos_descricao"><?= $pessoaJuridica->servicos_descricao ?>

                                    </textarea>

                            </div>



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

                                                <button type="button" onclick="window.location.href='<?= base_url('usuario/DesativarConta/' . $pessoaJuridica->usuarios_id) ?>'" name="deleteAll" class="btn-finalizar">Sim</button>
                                            </div>



                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn-finalizar">Editar</button>
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
            document.getElementById("form-servico").style.display = 'none';

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