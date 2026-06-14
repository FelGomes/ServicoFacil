<?php redirectPages() ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaborHUB</title>
    <link rel="stylesheet" href="<?= base_url('Public/template/Css/adm.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Public/template/Images/favicon.png') ?>" type="image/x-icon">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <style>
        .detalhamento {
            margin-top: 50px;
            display: flex;
            justify-content: flex-start;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.16);
            border-radius: 5px;
            /* box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.14); */
        }

        .botaoModalDeletar {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>



</head>

<body>

    <?php $fotoPerfil = $_SESSION['usuarios_logado']->usuarios_imagem ?? ''; ?>

    <?php $usuarioTipo = $_SESSION['usuarios_logado']->pf_tipo ?? '' ?>

    <?php if ($usuarioTipo === 'Cliente'): ?>

        <?php $nomeUsuario = $_SESSION['usuarios_logado']->pf_nome . ' ' . $_SESSION['usuarios_logado']->pf_sobrenome; ?>



    <?php else: ?>

        <?php $nomeUsuario = $_SESSION['usuarios_logado']->pj_nomeFantasia ?? ''; ?>


    <?php endif; ?>

    <main>
        <?php if (isset($_SESSION['msg'])): ?>

        <?php

            echo msg(
                $_SESSION['msg']['texto'],
                $_SESSION['msg']['color'],
            );

            unset($_SESSION['msg']);





        endif;  ?>

        <!-- Gatilho (Botão) -->
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <!-- Sidebar -->
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark min-vh-100">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white sticky-top">
                        <span class="fs-5 d-none d-sm-inline mt-3 mb-3"> <img class="perfil" src="<?= base_url($fotoPerfil) ?>" alt="Foto Escolhida"> <?= esc($nomeUsuario) ?></span>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item mt-4">
                                <a href="<?= base_url('adm/index') ?>" class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">DashBoard</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/listarClientes') ?>" class="nav-link px-0 align-middle text-white">
                                    <i class="bi bi-person fs-4"></i> <span class="ms-1 d-none d-sm-inline">Clientes</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('admin/listarProfissional') ?>" class="nav-link px-0 align-middle text-white">
                                    <i class="bi bi-building fs-4"></i> <span class="ms-1 d-none d-sm-inline">Profissionais</span>
                                </a>
                            </li>
                        </ul>

                        <hr>

                        <div class="sair">
                            <a href="<?= base_url('login/logout') ?>" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-arrow-bar-left fs-4"></i> <span class="ms-1 d-none d-sm-inline">Sair</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo Principal -->
                <div class="col py-3">
                    <h4>Detalhamento de usuários</h4>

                    <!-- EDITAR PESSOA FISICA -->
                    <?php if (!empty($detalharUsuariosPF) && is_object($detalharUsuariosPF)): ?>
                        <div class="detalhamento">
                            <div class="card mb-3" style="max-width: 640px;">
                                <div class="row g-0 p-3">
                                    <div class="col-md-4 ">
                                        <img src="<?= base_url($detalharUsuariosPF->usuarios_imagem) ?>" class="foto img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3"><strong><?= esc($detalharUsuariosPF->pf_nome . ' ' . $detalharUsuariosPF->pf_sobrenome) ?> </strong></h4>
                                            <h6 class="card-text"><strong>Data nascimento:</strong> <?= date('d/m/Y', strtotime($detalharUsuariosPF->pf_dataNascimento)) ?></h6>
                                            <h6 class="card-text"><strong>Telefone: </strong><?= esc($detalharUsuariosPF->usuarios_telefone) ?></h6>
                                            <h6 class="card-text"><strong>Gênero:</strong> <?= esc($detalharUsuariosPF->pf_genero) ?></h6>
                                            <h6 class="card-text"><strong>Email:</strong> <?= esc($detalharUsuariosPF->usuarios_email) ?></h6>
                                            <h6 class="card-text"><strong>Cidade: </strong> <?= esc($detalharUsuariosPF->endereco_cidade . ' - ' . $detalharUsuariosPF->endereco_uf) ?></h6>
                                            <h6 class="card-text"><strong>Criado em: </strong> <?= date('d/m/Y', strtotime($detalharUsuariosPF->usuarios_criado_em)) ?></h6>
                                            <h6 class="card-text"><strong>Atualizado em: </strong><?= date('d/m/Y', strtotime($detalharUsuariosPF->usuarios_atualizado_em)) ?></h6>
                                        </div>
                                    </div>

                                    <div class="cardBotao mt-5 ">
                                        <button type="button" onclick="window.location.href='<?= base_url('admin/listarClientes') ?>'" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Voltar</button>


                                        <!-- MODAL PARA ALTERAR -->
                                        <?php if ($detalharUsuariosPF->usuarios_deletado_em == '0000-00-00 00:00:00'): ?>
                                            <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggleEditar" data-bs-toggle="modal"> <i class="bi bi-pencil-fill"></i> Editar</button>
                                            <div class="modal fade modal-xl" id="exampleModalToggleEditar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Solicitação de serviço</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> <!--COnteudo com os formulario-->
                                                            <h4 class="text-center">Alteração de dados de <strong><?= esc($detalharUsuariosPF->pf_nome . ' ' . $detalharUsuariosPF->pf_sobrenome) ?></strong></h4>
                                                            <form action="<?= base_url('admin/editarClientesPf/' . $detalharUsuariosPF->usuarios_id) ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-6 mt-4 mb-2">
                                                                        <label for="pf_nome">Nome </label>
                                                                        <input type="text" name="pf_nome" id="pf_nome" placeholder="Digite seu primeiro nome" class="form-control" value="<?= esc($detalharUsuariosPF->pf_nome) ?>">
                                                                    </div>

                                                                    <div class="col-md-6 mt-4 mb-2">
                                                                        <label for="pf_sobrenome">Sobrenome </label>
                                                                        <input type="text" name="pf_sobrenome" id="pf_sobrenome" placeholder="Digite seu sobrenome" class="form-control" value="<?= esc($detalharUsuariosPF->pf_sobrenome) ?>">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="pf_dataNascimento">Data de nascimento </label>
                                                                        <input type="date" name="pf_dataNascimento" id="pf_dataNascimento" value="<?= $detalharUsuariosPF->pf_dataNascimento ?>" readonly class="form-control">
                                                                    </div>


                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="pf_genero">Gênero</label>
                                                                        <select name="pf_genero" class="form-control" id="pf_genero">
                                                                            <option selected>Selecione seu gênero</option>
                                                                            <option value="Masculino" <?= $detalharUsuariosPF->pf_genero == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                                                            <option value="Feminino" <?= $detalharUsuariosPF->pf_genero == 'Feminino' ? 'selected' : '' ?>>Feminino</option>
                                                                            <option value="Outro" <?= $detalharUsuariosPF->pf_genero == 'Outro' ? 'selected' : '' ?>>Outro</option>
                                                                        </select>
                                                                    </div>


                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="pf_cpf">CPF</label>
                                                                        <input type="text" name="pf_cpf" id="pf_cpf" value="<?= esc($detalharUsuariosPF->pf_cpf) ?>" placeholder="Digite seu CPF" class="form-control cpf" readonly>
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_telefone">Telefone/Celular</label>
                                                                        <input type="tel" name="usuarios_telefone" value="<?= esc($detalharUsuariosPF->usuarios_telefone) ?>" id="usuarios_telefone" placeholder="Digite seu telefone" class="form-control tel">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_email">Email</label>
                                                                        <input type="email" name="usuarios_email" value="<?= esc($detalharUsuariosPF->usuarios_email) ?>" id="usuarios_email" placeholder="Digite seu email" class="form-control ">
                                                                    </div>


                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_senha_hash">Senha</label>
                                                                        <input type="password" name="usuarios_senha_hash" id="usuarios_senha_hash" placeholder="Digite sua senha" class="form-control ">

                                                                    </div>


                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_rua">Rua/Logradouro </label>
                                                                        <input type="text" name="endereco_rua" value="<?= esc($detalharUsuariosPF->endereco_rua) ?>" id="endereco_rua" placeholder="Digite sua rua" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_bairro">Bairro </label>
                                                                        <input type="text" name="endereco_bairro" value="<?= esc($detalharUsuariosPF->endereco_bairro) ?>" id="endereco_bairro" placeholder="Digite seu bairro" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_complemento">Complemento </label>
                                                                        <input type="text" name="endereco_complemento" value="<?= esc($detalharUsuariosPF->endereco_complemento) ?>" id="endereco_complemento" placeholder="Apto, Bloco, Quadra, Etc..." class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_numero">Número </label>
                                                                        <input type="text" name="endereco_numero" value="<?= esc($detalharUsuariosPF->endereco_numero) ?>" id="endereco_numero" placeholder="Número da residência" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_cidade">Cidade </label>
                                                                        <input type="text" name="endereco_cidade" value="<?= esc($detalharUsuariosPF->endereco_cidade) ?>" id="endereco_cidade" placeholder="Digite sua cidade" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_uf">UF</label>
                                                                        <select name="endereco_uf" class="form-control" id="endereco_uf">
                                                                            <option selected disabled>Selecione o UF</option>
                                                                            <option value="AC">AC</option>
                                                                            <option value="AL">AL</option>
                                                                            <option value="AP">AP</option>
                                                                            <option value="AM">AM</option>
                                                                            <option value="BA">BA</option>
                                                                            <option value="CE">CE</option>
                                                                            <option value="DF">DF</option>
                                                                            <option value="ES">ES</option>
                                                                            <option value="GO">GO</option>
                                                                            <option value="MA">MA</option>
                                                                            <option value="MT">MT</option>
                                                                            <option value="MS">MS</option>
                                                                            <option value="MG">MG</option>
                                                                            <option value="PA">PA</option>
                                                                            <option value="PB">PB</option>
                                                                            <option value="PR">PR</option>
                                                                            <option value="PE">PE</option>
                                                                            <option value="PI">PI</option>
                                                                            <option value="RJ">RJ</option>
                                                                            <option value="RN">RN</option>
                                                                            <option value="RS">RS</option>
                                                                            <option value="RO">RO</option>
                                                                            <option value="RR">RR</option>
                                                                            <option value="SC">SC</option>
                                                                            <option value="SP">SP</option>
                                                                            <option value="SE">SE</option>
                                                                            <option value="TO">TO</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_ativo">Status usuários</label>
                                                                        <select name="usuarios_ativo" class="form-control" id="usuarios_ativo">
                                                                            <option selected>Selecione o status</option>
                                                                            <option value="1" <?= $detalharUsuariosPF->usuarios_ativo == '1' ? 'selected' : '' ?>>Ativo</option>
                                                                            <option value="0" <?= $detalharUsuariosPF->usuarios_ativo == '0' ? 'selected' : '' ?>>Desativar</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_is_admin">Tipo usuário</label>
                                                                        <select name="usuarios_is_admin" class="form-control" id="usuarios_is_admin">
                                                                            <option selected>Selecione o tipo do usuário</option>
                                                                            <option value="1" <?= $detalharUsuariosPF->usuarios_is_admin == '1' ? 'selected' : '' ?>>Administrador</option>
                                                                            <option value="0" <?= $detalharUsuariosPF->usuarios_is_admin == '0' ? 'selected' : '' ?>> Usuário comum</option>

                                                                        </select>
                                                                    </div>

                                                                    <div class="modal-footer mt-2">
                                                                        <div class="botaoModalDeletar">

                                                                            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary"> Sair</button>
                                                                            <button type="submit" name="editar" class="btn btn-primary">Editar</button>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>

                                        <?php if ($detalharUsuariosPF->usuarios_deletado_em == '0000-00-00 00:00:00'): ?>
                                            <!-- MODAL PARA DELETAR -->
                                            <button type="button" class="btn btn-danger" data-bs-target="#exampleModalToggleDeletar" data-bs-toggle="modal"> <i class="bi bi-trash3-fill"></i> Deletar</button>

                                            <div class="modal fade modal-lg" id="exampleModalToggleDeletar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> <!--COnteudo com os formulario-->
                                                            <div class="row">
                                                                <form action="" method="post">
                                                                    <h4 class="text-center ">Deseja deletar este usuário?</h4>
                                                                    <p class="text-center mt-2 mb-5">Ao deletar, apenas o administrador poderá recuperar</p>

                                                                    <div class="botaoModalDeletar mt-3">

                                                                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary"> Não</button>
                                                                        <button type="button" onclick="window.location.href='<?= base_url('admin/excluirUsuario/' . $detalharUsuariosPF->usuarios_id) ?>'" class="btn btn-primary">Sim</button>
                                                                    </div>



                                                                </form>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        <?php else: ?>
                                            <button type="button" class="btn btn-info" onclick="window.location.href='<?= base_url('admin/desfazerExclusao/' . $detalharUsuariosPF->usuarios_id) ?>'"><i class="bi bi-arrow-counterclockwise"></i> Desfazer</button>

                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Fim do detalhamento de pessoa física -->

                    <?php endif; ?>

                    <!-- EDITAR PESSOA JURIDICA -->
                    <?php if (!empty($detalharUsuariosPj) && is_object($detalharUsuariosPj)): ?>
                        <div class="detalhamento">

                            <div class="card mb-3" style="max-width: 640px;">
                                <div class="row g-0 p-3">
                                    <div class="col-md-4 ">
                                        <img src="<?= base_url($detalharUsuariosPj->usuarios_imagem) ?>" class="foto img-fluid rounded-start mt-4" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3"><strong><?= esc($detalharUsuariosPj->pj_razaoSocial) ?> </strong></h4>
                                            <h6 class="card-text"><strong>Data fundação:</strong> <?= date('d/m/Y', strtotime($detalharUsuariosPj->pj_dataFundacao)) ?></h6>
                                            <h6 class="card-text"><strong>Telefone: </strong><?= esc($detalharUsuariosPj->usuarios_telefone) ?></h6>
                                            <h6 class="card-text"><strong>Email:</strong> <?= esc($detalharUsuariosPj->usuarios_email) ?></h6>
                                            <h6 class="card-text"><strong>Cidade: </strong> <?= esc($detalharUsuariosPj->endereco_cidade . ' - ' . $detalharUsuariosPj->endereco_uf) ?></h6>
                                            <h6 class="card-text"><strong>Criado em: </strong> <?= date('d/m/Y', strtotime($detalharUsuariosPj->usuarios_criado_em)) ?></h6>
                                            <h6 class="card-text"><strong>Atualizado em: </strong><?= date('d/m/Y', strtotime($detalharUsuariosPj->usuarios_atualizado_em)) ?></h6>
                                        </div>
                                    </div>

                                    <div class="cardBotao mt-5 ">
                                        <button type="button" onclick="window.location.href='<?= base_url('admin/listarClientes') ?>'" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Voltar</button>


                                        <!-- MODAL PARA ALTERAR -->
                                        <?php if ($detalharUsuariosPj->usuarios_deletado_em == '0000-00-00 00:00:00'): ?>
                                            <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggleEditar" data-bs-toggle="modal"> <i class="bi bi-pencil-fill"></i> Editar</button>
                                            <div class="modal fade modal-xl" id="exampleModalToggleEditar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Solicitação de serviço</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> <!--COnteudo com os formulario-->
                                                            <h4 class="text-center">Alteração de dados de <strong><?= esc($detalharUsuariosPj->pj_razaoSocial) ?></strong></h4>
                                                            <form action="<?= base_url('admin/editarClientesPJ/' . $detalharUsuariosPj->usuarios_id) ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-6 mt-4 mb-2">
                                                                        <label for="pj_razaoSocial">Razão social </label>
                                                                        <input type="text" name="pj_razaoSocial" id="pj_razaoSocial" placeholder="Digite a razão social" class="form-control" value="<?= esc($detalharUsuariosPj->pj_razaoSocial) ?>">
                                                                    </div>

                                                                    <div class="col-md-6 mt-4 mb-2">
                                                                        <label for="pj_nomeFantasia">Nome Fantasia </label>
                                                                        <input type="text" name="pj_nomeFantasia" id="pj_nomeFantasia" placeholder="Digite o nome fantasia" class="form-control" value="<?= esc($detalharUsuariosPj->pj_nomeFantasia) ?>">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="pj_dataFundacao">Data de fundação </label>
                                                                        <input type="date" name="pf_dataNascimento" id="pf_dataNascimento" value="<?= $detalharUsuariosPj->pj_dataFundacao ?>" readonly class="form-control">
                                                                    </div>


                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="pj_cnpj">CNPJ</label>
                                                                        <input type="text" name="pj_cnpj" id="pj_cnpj" value="<?= esc($detalharUsuariosPj->pj_cnpj) ?>" placeholder="Digite seu CNPJ" class="form-control cnpj" readonly>
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_telefone">Telefone/Celular</label>
                                                                        <input type="tel" name="usuarios_telefone" value="<?= esc($detalharUsuariosPj->usuarios_telefone) ?>" id="usuarios_telefone" placeholder="Digite seu telefone" class="form-control tel">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_email">Email</label>
                                                                        <input type="email" name="usuarios_email" value="<?= esc($detalharUsuariosPj->usuarios_email) ?>" id="usuarios_email" placeholder="Digite seu email" class="form-control ">
                                                                    </div>


                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_senha_hash">Senha</label>
                                                                        <input type="password" name="usuarios_senha_hash" id="usuarios_senha_hash" placeholder="Digite sua senha" class="form-control ">

                                                                    </div>


                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_rua">Rua/Logradouro </label>
                                                                        <input type="text" name="endereco_rua" value="<?= esc($detalharUsuariosPj->endereco_rua) ?>" id="endereco_rua" placeholder="Digite sua rua" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_bairro">Bairro </label>
                                                                        <input type="text" name="endereco_bairro" value="<?= esc($detalharUsuariosPj->endereco_bairro) ?>" id="endereco_bairro" placeholder="Digite seu bairro" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_complemento">Complemento </label>
                                                                        <input type="text" name="endereco_complemento" value="<?= esc($detalharUsuariosPj->endereco_complemento) ?>" id="endereco_complemento" placeholder="Apto, Bloco, Quadra, Etc..." class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_numero">Número </label>
                                                                        <input type="text" name="endereco_numero" value="<?= esc($detalharUsuariosPj->endereco_numero) ?>" id="endereco_numero" placeholder="Número da residência" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_cidade">Cidade </label>
                                                                        <input type="text" name="endereco_cidade" value="<?= esc($detalharUsuariosPj->endereco_cidade) ?>" id="endereco_cidade" placeholder="Digite sua cidade" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="endereco_uf">UF</label>
                                                                        <select name="endereco_uf" class="form-control" id="endereco_uf">
                                                                            <option selected disabled>Selecione o UF</option>
                                                                            <option value="AC">AC</option>
                                                                            <option value="AL">AL</option>
                                                                            <option value="AP">AP</option>
                                                                            <option value="AM">AM</option>
                                                                            <option value="BA">BA</option>
                                                                            <option value="CE">CE</option>
                                                                            <option value="DF">DF</option>
                                                                            <option value="ES">ES</option>
                                                                            <option value="GO">GO</option>
                                                                            <option value="MA">MA</option>
                                                                            <option value="MT">MT</option>
                                                                            <option value="MS">MS</option>
                                                                            <option value="MG">MG</option>
                                                                            <option value="PA">PA</option>
                                                                            <option value="PB">PB</option>
                                                                            <option value="PR">PR</option>
                                                                            <option value="PE">PE</option>
                                                                            <option value="PI">PI</option>
                                                                            <option value="RJ">RJ</option>
                                                                            <option value="RN">RN</option>
                                                                            <option value="RS">RS</option>
                                                                            <option value="RO">RO</option>
                                                                            <option value="RR">RR</option>
                                                                            <option value="SC">SC</option>
                                                                            <option value="SP">SP</option>
                                                                            <option value="SE">SE</option>
                                                                            <option value="TO">TO</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_ativo">Status usuários</label>
                                                                        <select name="usuarios_ativo" class="form-control" id="usuarios_ativo">
                                                                            <option selected>Selecione o status</option>
                                                                            <option value="1" <?= $detalharUsuariosPj->usuarios_ativo == '1' ? 'selected' : '' ?>>Ativo</option>
                                                                            <option value="0" <?= $detalharUsuariosPj->usuarios_ativo == '0' ? 'selected' : '' ?>>Desativar</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 mt-3 mb-2">
                                                                        <label for="usuarios_is_admin">Tipo usuário</label>
                                                                        <select name="usuarios_is_admin" class="form-control" id="usuarios_is_admin">
                                                                            <option selected>Selecione o tipo do usuário</option>
                                                                            <option value="1" <?= $detalharUsuariosPj->usuarios_is_admin == '1' ? 'selected' : '' ?>>Administrador</option>
                                                                            <option value="0" <?= $detalharUsuariosPj->usuarios_is_admin == '0' ? 'selected' : '' ?>> Usuário comum</option>

                                                                        </select>
                                                                    </div>

                                                                    <div class="modal-footer mt-2">
                                                                        <div class="botaoModalDeletar">

                                                                            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary"> Sair</button>
                                                                            <button type="submit" name="editar" class="btn btn-primary">Editar</button>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>

                                        <?php if ($detalharUsuariosPj->usuarios_deletado_em == '0000-00-00 00:00:00'): ?>
                                            <!-- MODAL PARA DELETAR -->
                                            <button type="button" class="btn btn-danger" data-bs-target="#exampleModalToggleDeletar" data-bs-toggle="modal"> <i class="bi bi-trash3-fill"></i> Deletar</button>

                                            <div class="modal fade modal-lg" id="exampleModalToggleDeletar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> <!--COnteudo com os formulario-->
                                                            <div class="row">
                                                                <form action="" method="post">
                                                                    <h4 class="text-center ">Deseja deletar este usuário?</h4>
                                                                    <p class="text-center mt-2 mb-5">Ao deletar, apenas o administrador poderá recuperar</p>

                                                                    <div class="botaoModalDeletar mt-3">

                                                                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary"> Não</button>
                                                                        <button type="button" onclick="window.location.href='<?= base_url('admin/excluirUsuario/' . $detalharUsuariosPj->usuarios_id) ?>'" class="btn btn-primary">Sim</button>
                                                                    </div>



                                                                </form>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        <?php else: ?>
                                            <button type="button" class="btn btn-info" onclick="window.location.href='<?= base_url('admin/desfazerExclusao/' . $detalharUsuariosPj->usuarios_id) ?>'"><i class="bi bi-arrow-counterclockwise"></i> Desfazer</button>

                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>

                        </div>
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





</body>

</html>