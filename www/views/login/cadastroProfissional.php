<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaborHUB</title>
    <!-- <link rel="stylesheet" href="../../Assets/Css/style.css">
    <link rel="stylesheet" href="../../Assets/Css/mediaQuery.css"> -->
    <link rel="stylesheet" href="<?= base_url('Public/template/Css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Public/template/Css/mediaQuery.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Public/template/Images/favicon.png') ?>" type="image/x-icon">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <main>

        <?php if (isset($_SESSION['msg'])): ?>

            <?php

            echo msg(
                $_SESSION['msg']['texto'],
                $_SESSION['msg']['color'],
            );

            unset($_SESSION['msg']);





            ?>

        <?php endif; ?>

        <div class="container mt-3 mb-5 border">
            <div class="row">
                <h4 class="text-center mt-3">Preencha seus dados pessoais e endereço - Profissional</h4>
                <h5 class="text-center mt-5">Foto de perfil</h5>

                <form action="<?= base_url('usuario/continuacaoProfissional') ?>" method="post" enctype="multipart/form-data"> <!--Formulario para enviou de validação de dados -->
                    <div class="text-center">
                        <i class="iconeFoto bi bi-person-circle"></i>
                        <div class="inserir text-center">

                            <input type="file" name="usuarios_imagem" id="imagem">
                        </div>
                    </div>
                    <div class="cadastro mt-4">
                        <h5 class="text-start "> Seu tipo de perfil se encaixa como?</h5>
                        <div class="d-flex justify-content-start gap-4">

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="usarios_tipo" id="usuarios_tipo1" value="pessoa_fisica" checked onclick="mostrar('pf')">
                                <label for="usuarios_tipo1" class="form-check-label">
                                    Pessoa Física
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="usarios_tipo" id="usuarios_tipo2" value="pessoa_juridica" onclick="mostrar('pj')">
                                <label class="form-check-label" for="usuarios_tipo2">
                                    Pessoa Jurídica
                                </label>
                            </div>

                        </div>

                    </div>


                    <!-- Cadastro de pessoa fisica -->
                    <div id="form-pf" class="col-md-12 mt-4">
                        <h5 class="text-start"> <i class="bi bi-person-fill fs-3 "></i> Dados Pessoais</h5>
                        <div class="row">

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pf_nome">Nome </label>
                                <input type="text" name="pf_nome" id="pf_nome" placeholder="Digite seu primeiro nome" class="form-control" required value="<?= $_POST['pf_nome'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pf_sobrenome">Sobrenome </label>
                                <input type="text" name="pf_sobrenome" id="pf_sobrenome" placeholder="Digite seu sobrenome" class="form-control" required value="<?= $_POST['pf_sobrenome'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pf_dataNascimento">Data de nascimento </label>
                                <input type="date" name="pf_dataNascimento" id="pf_dataNascimento" class="form-control" required value="<?= $_POST['pf_dataNascimento'] ?? '' ?>">
                            </div>


                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pf_genero">Gênero</label>
                                <select name="pf_genero" class="form-control" id="pf_genero" value="<?= $_POST['pf_genero'] ?? '' ?>">
                                    <option selected>Selecione seu gênero</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>


                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pf_cpf">CPF</label>
                                <input type="text" name="pf_cpf" id="pf_cpf" placeholder="Digite seu CPF" class="form-control cpf" required value="<?= $_POST['pf_cpf'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="usuarios_telefone">Telefone/Celular</label>
                                <input type="tel" name="usuarios_telefone" id="usuarios_telefone_pf" placeholder="Digite seu telefone" class="form-control tel" required value="<?= $_POST['usuarios_telefone'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="usuarios_email">Email</label>
                                <input type="email" name="usuarios_email" id="usuarios_email_pf" placeholder="Digite seu email" class="form-control" required value="<?= $_POST['usuarios_email'] ?? '' ?>">
                            </div>


                            <div class="col-md-6 mt-4 mb-2">
                                <label for="usuarios_senha_hash">Senha</label>
                                <input type="password" name="usuarios_senha_hash" id="usuarios_senha_hash_pf" placeholder="Digite sua senha" class="form-control " required>


                            </div>

                            <h5 class="text-start mt-5 "><i class="bi bi-house-fill fs-3"></i> Endereço</h5>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_rua">Rua/Logradouro </label>
                                <input type="text" name="endereco_rua" id="endereco_rua_pf" placeholder="Digite sua rua" class="form-control" required value="<?= $_POST['endereco_rua'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_bairro">Bairro </label>
                                <input type="text" name="endereco_bairro" id="endereco_bairro_pf" placeholder="Digite seu bairro" class="form-control" required value="<?= $_POST['endereco_bairro'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_complemento">Complemento </label>
                                <input type="text" name="endereco_complemento" id="endereco_complemento_pf" placeholder="Apto, Bloco, Quadra, Etc..." class="form-control" required value="<?= $_POST['endereco_complemento'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_numero">Número </label>
                                <input type="text" name="endereco_numero" id="endereco_numero_pf" placeholder="Número da residência" class="form-control" required value="<?= $_POST['endereco_numero'] ?? '' ?>">
                            </div>

                            <div class="col-md-3 mt-4 mb-2">
                                <label for="endereco_cep">CEP </label>
                                <input type="text" name="endereco_cep" id="endereco_cep_pf" placeholder="Informe o CEP" class="form-control" required value="<?= $_POST['endereco_cep'] ?? '' ?>">
                            </div>

                            <div class="col-md-3 mt-4 mb-2">
                                <label for="endereco_cidade">Cidade </label>
                                <input type="text" name="endereco_cidade" id="endereco_cidade_pf" placeholder="Digite sua cidade" class="form-control" required value="<?= $_POST['endereco_cidade'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_uf">UF</label>
                                <select name="endereco_uf" class="form-control" id="endereco_uf_pf" value="<?= $_POST['endereco_uf'] ?? '' ?>">
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

                            <div class="botoes col-md-6 ms-auto mt-5 mb-4">
                                <button type="reset" class="btn-reset">Limpar formulario</button>
                                <button type="submit" name="enviar" class="btn-submit">Proximo</button>

                            </div>

                        </div>




                    </div>

                    <!-- Pessoa juridica -->
                    <div id="form-pj" style="display:none;" class="cold-md-12 mt-4">
                        <h5 class="text-start"> <i class="bi bi-building-fill fs-3"></i> Dados Empresarial</h5>
                        <div class="row">

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pj_razaoSocial">Razão Social </label>
                                <input type="text" name="pj_razaoSocial" id="pj_razaoSocial" placeholder="Digite a razão social" class="form-control" required value="<?= $_POST['pj_razaoSocial'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pj_nomeFantasia">Nome Fantasia </label>
                                <input type="text" name="pj_nomeFantasia" id="pj_nomeFantasia" placeholder="Digite o nome fantasia" class="form-control" required value="<?= $_POST['pj_nomeFantasia'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pj_dataFundacao">Data de fundação </label>
                                <input type="date" name="pj_dataFundacao" id="pj_dataFundacao" class="form-control" required value="<?= $_POST['pj_dataFundacao'] ?? '' ?>">
                            </div>


                            <div class="col-md-6 mt-4 mb-2">
                                <label for="pj_cnpj">CNPJ</label>
                                <input type="text" name="pj_cnpj" id="pj_cnpj" placeholder="Digite seu CNPJ" class="form-control cpf" required value="<?= $_POST['pj_cnpj'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="usuarios_telefone">Telefone/Celular</label>
                                <input type="tel" name="usuarios_telefone" id="usuarios_telefone" placeholder="Digite seu telefone" class="form-control tel" required value="<?= $_POST['usuarios_telefone'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="usuarios_email">Email</label>
                                <input type="email" name="usuarios_email" id="usuarios_email" placeholder="Digite seu email" class="form-control " required value="<?= $_POST['usuarios_email'] ?? '' ?>">
                            </div>


                            <div class="col-md-6 mt-4 mb-2">
                                <label for="usuarios_senha_hash">Senha</label>
                                <input type="password" name="usuarios_senha_hash" id="usuarios_senha_hash" placeholder="Digite sua senha" class="form-control " required>


                            </div>

                            <h5 class="text-start mt-5 "><i class="bi bi-house-fill fs-3"></i> Endereço</h5>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_rua">Rua/Logradouro </label>
                                <input type="text" name="endereco_rua" id="endereco_rua" placeholder="Digite sua rua" class="form-control" required value="<?= $_POST['endereco_rua'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_bairro">Bairro </label>
                                <input type="text" name="endereco_bairro" id="endereco_bairro" placeholder="Digite seu bairro" class="form-control" required value="<?= $_POST['endereco_bairro'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_complemento">Complemento </label>
                                <input type="text" name="endereco_complemento" id="endereco_complemento" placeholder="Apto, Bloco, Quadra, Etc..." class="form-control" required value="<?= $_POST['endereco_complemento'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_numero">Número </label>
                                <input type="text" name="endereco_numero" id="endereco_numero" placeholder="Número da residência" class="form-control" required value="<?= $_POST['endereco_numero'] ?? '' ?>">
                            </div>

                            <div class="col-md-3 mt-4 mb-2">
                                <label for="endereco_cep">CEP </label>
                                <input type="text" name="endereco_cep" id="endereco_cep" placeholder="Informe o CEP" class="form-control" required value="<?= $_POST['endereco_cep'] ?? '' ?>">
                            </div>

                            <div class="col-md-3 mt-4 mb-2">
                                <label for="endereco_cidade">Cidade </label>
                                <input type="text" name="endereco_cidade" id="endereco_cidade" placeholder="Digite sua cidade" class="form-control" required value="<?= $_POST['endereco_cidade'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 mt-4 mb-2">
                                <label for="endereco_uf">UF</label>
                                <select name="endereco_uf" class="form-control" id="endereco_uf" value="<?= $_POST['endereco_uf'] ?? '' ?>">
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

                            <div class="botoes col-md-6 ms-auto mt-5 mb-4">
                                <button type="reset" class="btn-reset">Limpar formulario</button>
                                <button type="submit" class="btn-submit" name="enviar">Próximo</button>

                            </div>


                        </div>


                    </div>

            </div>
            </form>
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
            const pf = document.getElementById("form-pf");
            const pj = document.getElementById("form-pj");

            if (tipo === 'pf') {
                pf.style.display = 'block';
                pj.style.display = 'none';

                configurarCampos(pf, false); // Ativa PF
                configurarCampos(pj, true); // Desativa PJ
            } else {
                pf.style.display = 'none';
                pj.style.display = 'block';

                configurarCampos(pf, true); // Desativa PF
                configurarCampos(pj, false); // Ativa PJ
            }
        }

        function configurarCampos(container, desativar) {
            const elementos = container.querySelectorAll('input, select');
            elementos.forEach(el => {
                el.disabled = desativar;
                // Opcional: remove o required para evitar erros de validação oculta
                if (desativar) el.removeAttribute('required');
                else el.setAttribute('required', 'required');
            });
        }

        window.onload = function() {
            mostrar('pf'); // Garante o estado inicial correto
        };
    </script>



</body>

</html>