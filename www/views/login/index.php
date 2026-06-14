<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LaborHUB</title>
    <!-- <link rel="stylesheet" href="../../Assets/Css/style1.css"> -->
    <link rel="stylesheet" href="<?= base_url('Public/template/Css/style1.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Public/template/Css/mediaLogin.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Public/template/Images/favicon.png') ?>" type="image/x-icon">
    <!-- <link rel="stylesheet" href="../../Assets/Css/mediaLogin.css"> -->



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


</head>

<body>

    <?php if (isset($_SESSION['msg'])): ?>

        <?php

        echo msg(
            $_SESSION['msg']['texto'],
            $_SESSION['msg']['color'],
        );

        unset($_SESSION['msg']);



        ?>

    <?php endif; ?>



    <main>
        <div class="container-box" style="height: 500px;">
            <div class="texto">

                <h3>Olá, seja bem vindo ao LaborHUB!</h3>
            </div>
            <div class="campos">
                <div class="row ">
                    <form action="<?= base_url('login/autenticar') ?>" method="post">
                        <div class="col-md-12 mb-3">
                            <label for="usuarios_email">Email</label>
                            <input type="email" name="usuarios_email" id="usuarios_email" placeholder="Digite seu email" class="login form-control" value="<?= $_SESSION['old'] ?? '' ?>" required>

                        </div>

                        <div class="col-md-12 ">
                            <label for="usuarios_senha_hash">Senha</label>
                            <input type="password" name="usuarios_senha_hash" id="usuarios_senha_hash" placeholder="Digite sua senha" class="login form-control" required>

                        </div>

                        <div class="mb-3 form-check col-md-12 d-flex justify-content-between align-items-center mt-2 link">
                            <div>
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                <label class="form-check-label text-start" for="rememberMe">Manter-me conectado</label>

                            </div>
                            <div>
                                <a href="<?= base_url('login/esqueciSenha') ?>">Esqueci minha senha</a>

                            </div>
                        </div>

                        <input type="submit" class="btn-submit mt-5" name="enviar" value="Entrar">
                        <div class="mt-2">
                            <p class="text-center mb-5">Ainda não tem conta? <a href="<?= base_url('usuario/escolherUsuario') ?>">Criar conta agora</a></p>
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


</body>

</html>