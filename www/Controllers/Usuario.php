<?php

namespace Controllers;

use DateTime;
use Models\Database as Conexao;

use PDO;
use \Utils\RenderView;


class Usuario extends RenderView
{


    private $usuario;
    private $endereco;
    private $pessoaFisica;
    private $pessoaJuridica;
    private $servico;
    private $login;


    public function __construct()
    {
        $this->usuario = new Conexao('usuarios');
        $this->endereco = new Conexao('endereco');
        $this->pessoaFisica = new Conexao('pessoaFisica');
        $this->pessoaJuridica = new Conexao('pessoaJuridica');
        $this->servico = new Conexao('servicos');

        $this->login = new Login();
    }

    public function index()
    {
        return $this->loadView('login/escolherUsuario', []);
    }

    public function flash(string $texto, string $tipo = 'succes'): array
    {
        return [
            'texto' => $texto,
            'tipo' => $tipo,
        ];
    }

    protected function redirect($path, $mensagem = null)
    {
        if ($mensagem) {
            $_SESSION['msg'] = $mensagem;
        }
        header("Location: {$path}");
        exit();
    }



    public function redirecionar($tipo = null)
    {
        if ($tipo === 'cliente') {
            return $this->loadView('login/cadastroCliente', []);
        } elseif ($tipo === 'profissional') {
            return $this->loadView('login/cadastroProfissional', []);
        } else {
            return $this->loadView('login/escolherUsuario', []);
        }
    }




    public function continuacaoProfissional()
    {
        $data = [];

        $_SESSION['cadastro_profissional'] = $_POST;

        if (
            !isset($_FILES['usuarios_imagem']) ||
            $_FILES['usuarios_imagem']['error'] !== 0
        ) {

            $_SESSION['msg'] = [
                'texto' => 'Informe uma imagem!',
                'color' => 'warning',
            ];

            return $this->loadView(
                'login/cadastroProfissional',
                $data
            );
        }

        $arquivo = $_FILES['usuarios_imagem'];

        // TAMANHO
        if (!$this->usuario->validaImagemPerfi($arquivo)) {

            $_SESSION['msg'] = [
                'texto' => 'Imagem maior que 2MB!',
                'color' => 'danger',
            ];

            return $this->loadView(
                'login/cadastroProfissional',
                $data
            );
        }

        // TIPO
        if (!$this->usuario->tipoImagem($arquivo)) {

            $_SESSION['msg'] = [
                'texto' => 'Formato inválido!',
                'color' => 'danger',
            ];

            return $this->loadView(
                'login/cadastroProfissional',
                $data
            );
        }

        // RESOLUÇÃO
        if (!$this->usuario->tamanhoImagem($arquivo)) {

            $_SESSION['msg'] = [
                'texto' => 'Imagem menor que 400x400!',
                'color' => 'danger',
            ];

            return $this->loadView(
                'login/cadastroProfissional',
                $data
            );
        }

        // MOVE UPLOAD
        $pasta = __DIR__ .
            '/../Public/template/UploadImages/';

        $nomeArquivo =
            uniqid() . '-' . basename($arquivo['name']);

        $caminhoFinal = $pasta . $nomeArquivo;

        if (
            !move_uploaded_file(
                $arquivo['tmp_name'],
                $caminhoFinal
            )
        ) {

            $_SESSION['msg'] = [
                'texto' => 'Erro upload imagem!',
                'color' => 'danger',
            ];

            return $this->loadView(
                'login/cadastroProfissional',
                $data
            );
        }

        $_SESSION['cadastro_profissional_imagem'] =
            'Public/template/UploadImages/' .
            $nomeArquivo;

        return $this->loadView(
            'login/cadastroServicoProfissional',
            []
        );
    }




    // METODO PARA CADASTAR PESSOA FISICA E PESSOA JURIDICA DO TIPO CLIENTE
    public function cadastrarCliente()
    {

        $data = [];

        $usuarios_imagem = 'UploadImages/default.png';

        // Validando se os dados foram ao menos enviado
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->loadView('login/cadastroCliente', $data);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES)) {
            $_SESSION['msg'] = [
                'texto' => 'Informe todos os dados abaixo!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        if (!isset($_FILES['usuarios_imagem']) || empty($_FILES['usuarios_imagem']) || $_FILES['usuarios_imagem']['error'] !== 0) {

            $_SESSION['msg'] = [
                'texto' => 'Atenção! Informe uma imagem para seu perfil!',
                'color' => 'warning',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        $arquivo = $_FILES['usuarios_imagem']; //Se passou por aqui, significa que recebeu a imagem


        // Validando se a imagem é maior que 2MB
        if (!$this->usuario->validaImagemPerfi($arquivo)) {
            $_SESSION['msg'] = [
                'texto' => "Atenção! Informe uma imagem até 2MB!",
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        // Verificando o tipo da imagem
        if (!$this->usuario->tipoImagem($arquivo)) {
            $_SESSION['msg'] = [
                'texto' => "Atenção! Formato não permitido, Selecione apenas JPEG, JPG ou PNG",
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if (!$this->usuario->tamanhoImagem($arquivo)) {
            $_SESSION['msg'] = [
                'texto' => "Atenção! Tamanho da imagem é menor que 400x400. Selecione uma imagem maior!",
                'color' => "danger",
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        // Se passou por tudo isso, a imagem enviada é válida

        $pasta = __DIR__ . '/../Public/template/UploadImages/';
        $nomeArquivo = uniqid() . "-" . basename($arquivo['name']);
        $caminhoFinal = $pasta . $nomeArquivo; //String para o banco de dados


        if (!move_uploaded_file($arquivo['tmp_name'], $caminhoFinal)) {
            $_SESSION['msg'] = [
                'texto' => "Erro ao fazer o upload da imagem!",
                'color' => "warning",
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        $usuarios_imagem = 'Public/template/UploadImages/' . $nomeArquivo;

        // echo "A rota funcionou!";
        // var_dump($_POST);
        // die();

        $post = $_POST;

        $values = [
            'usuarios_email' => $post['usuarios_email'] ?? '',
            'usuarios_imagem' => $usuarios_imagem,
            'usuarios_telefone' => $post['usuarios_telefone'] ?? '',
            'usuarios_senha_hash' => password_hash($post['usuarios_senha_hash'], PASSWORD_DEFAULT) ?? '',
            'usuarios_ativo' => 1,
            'usuarios_is_admin' => 0,



        ];

        $email = $values['usuarios_email'];
        $whereEmailExistente = "usuarios_email = '$email'";

        if ($this->usuario->select(null, $whereEmailExistente)->fetchAll(PDO::FETCH_OBJ)) {
            $_SESSION['msg'] = [
                'texto' => 'Email ja cadastrado',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }



        if (empty($values['usuarios_email'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe um email!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        if (empty($values['usuarios_telefone'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe um número de telefone!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($values['usuarios_telefone']) > 21) || (strlen($values['usuarios_telefone']) < 11)) {
            $_SESSION['msg'] = [
                'texto' => 'Informe um número de telefone válido!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if (!preg_match('/^[0-9()\-\s]+$/', $values['usuarios_telefone'])) {
            $_SESSION['msg'] = [
                'texto' => 'Telefone inválido!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        $usuarioID = $this->usuario->insert($values);


        if (!empty($post['pf_nome'])) {

            if ($usuarioID > 0) {
                $valuesPf = [
                    'pf_nome' => trim(
                        mb_convert_case($post['pf_nome'] ?? '', MB_CASE_TITLE, "UTF-8")
                    ),
                    'pf_sobrenome' => trim(
                        mb_convert_case($post['pf_sobrenome'] ?? '', MB_CASE_TITLE, "UTF-8")
                    ),
                    'pf_dataNascimento' =>  trim($post['pf_dataNascimento']) ?? '',
                    'pf_genero' => trim($post['pf_genero']) ?? '',
                    'pf_cpf' => trim($post['pf_cpf']) ?? '',
                    'pf_tipo' => 'Cliente',
                    'pf_usuarios_id' => $usuarioID,

                ];


                if (empty($valuesPf['pf_nome'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu nome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPf['pf_nome']) > 50) || (strlen($valuesPf['pf_nome']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para esse nome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPf['pf_sobrenome'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu sobrenome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPf['pf_sobrenome']) > 150) || (strlen($valuesPf['pf_sobrenome']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para esse sobrenome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPf['pf_dataNascimento'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe sua data de nascimento!',
                        'color' => 'danger',
                    ];
                }

                $dataNascimento = new DateTime($valuesPf['pf_dataNascimento']);
                $dataAtual = new DateTime();

                $idade = $dataAtual->diff($dataNascimento)->y;

                if ($idade <= 16) {
                    $_SESSION['msg'] = [
                        'texto' => 'Você não tem idade para utilizar esse sistema!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (!preg_match('/^[0-9()\-\s]+$/', $valuesPf['pf_cpf'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'CPF inválido',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPf['pf_cpf'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu CPF!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPf['pf_cpf']) > 14) || (strlen($valuesPf['pf_cpf']) < 11)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para o campo de CPF',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                $cpf = $valuesPf['pf_cpf'];
                $whereCPF = "pf_cpf = '$cpf'";

                $cpfExistente = $this->pessoaFisica->select(null, $whereCPF)->fetch(PDO::FETCH_OBJ);

                if ($cpfExistente) {
                    $_SESSION['msg'] = [
                        'texto' => 'CPF ja cadastrado no sistema',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }



                $this->pessoaFisica->insert($valuesPf);
            }
        } else {

            if ($usuarioID > 0) {
                $valuesPj = [
                    'pj_razaoSocial' => trim(
                        mb_convert_case($post['pj_razaoSocial'] ?? '', MB_CASE_TITLE, "UTF-8")
                    ),
                    'pj_nomeFantasia' => trim(
                        mb_convert_case($post['pj_nomeFantasia'] ?? '', MB_CASE_TITLE, "UTF-8")
                    ),
                    'pj_dataFundacao' => trim($post['pj_dataFundacao']) ?? '',
                    'pj_cnpj' => $post['pj_cnpj'] ?? '',
                    'pj_tipo' => 'Cliente',
                    'pj_usuarios_id' => $usuarioID,

                ];


                if (empty($valuesPj['pj_razaoSocial'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe sua Razão Social!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPj['pj_razaoSocial']) > 200) || (strlen($valuesPj['pj_razaoSocial']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para essa Razão Social!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPj['pj_nomeFantasia'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe o Nome Fantasia!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }


                if ((strlen($valuesPj['pj_nomeFantasia']) > 200) || (strlen($valuesPj['pj_nomeFantasia']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para esse Nome Fantasia!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPj['pj_dataFundacao'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe a data fundação da empresa',
                        'color' => 'danger',
                    ];
                }

                if (!preg_match('/^[0-9.\/\-\s]+$/', $valuesPj['pj_cnpj'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'CNPJ inválido',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }



                if (empty($valuesPj['pj_cnpj'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu CNPJ!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPj['pj_cnpj']) > 18) || (strlen($valuesPj['pj_cnpj']) < 14)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para o campo de CNPJ',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }


                $this->pessoaJuridica->insert($valuesPj);
            }
        }

        $valuesEndereco = [
            'endereco_nome' => trim($post['endereco_nome']) ?? '',
            'endereco_rua' => trim($post['endereco_rua']) ?? '',
            'endereco_bairro' => trim($post['endereco_bairro']) ?? '',
            'endereco_cep'    => trim($post['endereco_cep']) ?? '',
            'endereco_complemento'   => trim($post['endereco_complemento']) ?? '',
            'endereco_numero' => trim($post['endereco_numero']) ?? '',
            'endereco_descricao' => trim($post['endereco_descricao']) ?? '',
            'endereco_cidade' => trim(
                mb_convert_case($post['endereco_cidade'] ?? '', MB_CASE_TITLE, "UTF-8")
            ),
            'endereco_uf'    => trim($post['endereco_uf']) ?? '',
            'endereco_usuarios_id' => $usuarioID,

        ];

        // Validando a rua
        if (empty($valuesEndereco['endereco_rua'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe sua rua',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($valuesEndereco['endereco_rua']) > 200) || (strlen($valuesEndereco['endereco_rua']) < 3)) {
            $_SESSION['msg'] = [
                'texto' => 'Limite de caracter não permitido para essa Rua!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        // Validando o bairro
        if (empty($valuesEndereco['endereco_bairro'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe seu bairro',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($valuesEndereco['endereco_bairro']) > 200) || (strlen($valuesEndereco['endereco_bairro']) < 3)) {
            $_SESSION['msg'] = [
                'texto' => 'Limite de caracter não permitido para esse Bairro!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        // Validando a cidade
        if (empty($valuesEndereco['endereco_cidade'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe sua Cidade',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($valuesEndereco['endereco_cidade']) > 100) || (strlen($valuesEndereco['endereco_cidade']) < 4)) {
            $_SESSION['msg'] = [
                'texto' => 'Limite de caracter não permitido para o campo Cidade!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        // Validando o UF
        if (empty($valuesEndereco['endereco_uf'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe o UF do seu estado!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }



        if ($this->endereco->insert($valuesEndereco)) {

            $_SESSION['msg'] = [
                'texto' => "Usuário Cadastrado com sucesso!",
                'color' => 'success',

            ];

            return $this->loadView('login/index', $data);
        }
    }


    /**
     * CADASTAR PROFISSIONAIS PESSOA FISICA E PESSOA JURIDICA
     */
    public function cadastrarProfissional()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect(
                base_url('login/cadastroProfissional')
            );
        }


        // // JUNÇÃO DA SESSAO DA PRIMEIRA TELA E SEGUNDA TELA
        $post = array_merge($_SESSION['cadastro_profissional'] ?? [], $_POST);


        $usuarios_imagem =
            $_SESSION['cadastro_profissional_imagem'] ?? '';

        if (empty($usuarios_imagem)) {

            $_SESSION['msg'] = [
                'texto' => 'Informe uma imagem!',
                'color' => 'warning',
            ];

            return $this->redirect(
                base_url('login/cadastroProfissional')
            );
        }


        // Validação dos dados

        $values = [
            'usuarios_email' => $post['usuarios_email'] ?? '',
            'usuarios_imagem' => $usuarios_imagem,
            'usuarios_telefone' => $post['usuarios_telefone'] ?? '',
            'usuarios_senha_hash' => password_hash($post['usuarios_senha_hash'], PASSWORD_DEFAULT) ?? '',
            'usuarios_ativo' => 1,
            'usuarios_is_admin' => 0,
            'usuarios_criado_em' => date('Y-m-d'),

        ];

        $email = $values['usuarios_email'];
        $whereEmailExistente = "usuarios_email = '$email'";

        if ($this->usuario->select(null, $whereEmailExistente)->fetchAll(PDO::FETCH_OBJ)) {
            $_SESSION['msg'] = [
                'texto' => 'Email ja cadastrado',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }



        if (empty($values['usuarios_email'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe um email!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        if (empty($values['usuarios_telefone'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe um número de telefone!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($values['usuarios_telefone']) > 21) || (strlen($values['usuarios_telefone']) < 11)) {
            $_SESSION['msg'] = [
                'texto' => 'Informe um número de telefone válido!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if (!preg_match('/^[0-9()\-\s]+$/', $values['usuarios_telefone'])) {
            $_SESSION['msg'] = [
                'texto' => 'Telefone inválido!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        // Se deu certo para inserir na tabela usuarios, passamos para tabela de Pessoa Fisica
        $usuarioID = $this->usuario->insert($values);

        if (!$usuarioID) {
            $_SESSION['msg'] = [
                'texto' => "Erro cadastar usuario!",
                'color' => 'danger',
            ];

            return $this->redirect(base_url('login/cadastroProfissional'));
        }


        if (!empty($post['pf_nome'])) {

            $valuesPf = [
                'pf_nome' => $post['pf_nome'] ?? '',
                'pf_sobrenome' => $post['pf_sobrenome'] ?? '',
                'pf_dataNascimento' =>  $post['pf_dataNascimento'] ?? '',
                'pf_genero' => $post['pf_genero'] ?? '',
                'pf_cpf' => $post['pf_cpf'] ?? '',
                'pf_tipo' => 'Profissional',
                'pf_usuarios_id' => $usuarioID,

            ];


             if (empty($valuesPf['pf_nome'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu nome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPf['pf_nome']) > 50) || (strlen($valuesPf['pf_nome']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para esse nome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPf['pf_sobrenome'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu sobrenome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPf['pf_sobrenome']) > 150) || (strlen($valuesPf['pf_sobrenome']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para esse sobrenome!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPf['pf_dataNascimento'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe sua data de nascimento!',
                        'color' => 'danger',
                    ];
                }

                $dataNascimento = new DateTime($valuesPf['pf_dataNascimento']);
                $dataAtual = new DateTime();

                $idade = $dataAtual->diff($dataNascimento)->y;

                if ($idade <= 16) {
                    $_SESSION['msg'] = [
                        'texto' => 'Você não tem idade para utilizar esse sistema!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (!preg_match('/^[0-9()\-\s]+$/', $valuesPf['pf_cpf'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'CPF inválido',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPf['pf_cpf'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu CPF!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPf['pf_cpf']) > 14) || (strlen($valuesPf['pf_cpf']) < 11)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para o campo de CPF',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                $cpf = $valuesPf['pf_cpf'];
                $whereCPF = "pf_cpf = '$cpf'";

                $cpfExistente = $this->pessoaFisica->select(null, $whereCPF)->fetch(PDO::FETCH_OBJ);

                if ($cpfExistente) {
                    $_SESSION['msg'] = [
                        'texto' => 'CPF ja cadastrado no sistema',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);

            $this->pessoaFisica->insert($valuesPf);
        } else {

            $valuesPj = [
                'pj_razaoSocial' => $post['pj_razaoSocial'] ?? '',
                'pj_nomeFantasia' => $post['pj_nomeFantasia'] ?? '',
                'pj_dataFundacao' =>  $post['pj_dataFundacao'] ?? '',
                'pj_cnpj' => $post['pj_cnpj'] ?? '',
                'pj_tipo' => 'Profissional',
                'pj_usuarios_id' => $usuarioID,

            ];

             if (empty($valuesPj['pj_razaoSocial'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe sua Razão Social!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPj['pj_razaoSocial']) > 200) || (strlen($valuesPj['pj_razaoSocial']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para essa Razão Social!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPj['pj_nomeFantasia'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe o Nome Fantasia!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }


                if ((strlen($valuesPj['pj_nomeFantasia']) > 200) || (strlen($valuesPj['pj_nomeFantasia']) < 3)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para esse Nome Fantasia!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if (empty($valuesPj['pj_dataFundacao'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe a data fundação da empresa',
                        'color' => 'danger',
                    ];
                }

                if (!preg_match('/^[0-9.\/\-\s]+$/', $valuesPj['pj_cnpj'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'CNPJ inválido',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }



                if (empty($valuesPj['pj_cnpj'])) {
                    $_SESSION['msg'] = [
                        'texto' => 'Informe seu CNPJ!',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }

                if ((strlen($valuesPj['pj_cnpj']) > 18) || (strlen($valuesPj['pj_cnpj']) < 14)) {
                    $_SESSION['msg'] = [
                        'texto' => 'Limite de caracter não permitido para o campo de CNPJ',
                        'color' => 'danger',
                    ];

                    return $this->loadView('login/cadastroCliente', $data);
                }


            $this->pessoaJuridica->insert($valuesPj);
        }

        $valuesEndereco = [
            'endereco_rua' => $post['endereco_rua'] ?? '',
            'endereco_bairro' => $post['endereco_bairro'] ?? '',
            'endereco_cep'    => $post['endereco_cep'] ?? '',
            'endereco_complemento'   => $post['endereco_complemento'] ?? '',
            'endereco_numero' => $post['endereco_numero'] ?? '',
            'endereco_cidade' => $post['endereco_cidade'] ?? '',
            'endereco_uf'    => $post['endereco_uf'] ?? '',
            'endereco_usuarios_id' => $usuarioID,

        ];

         if (empty($valuesEndereco['endereco_rua'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe sua rua',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($valuesEndereco['endereco_rua']) > 200) || (strlen($valuesEndereco['endereco_rua']) < 3)) {
            $_SESSION['msg'] = [
                'texto' => 'Limite de caracter não permitido para essa Rua!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        // Validando o bairro
        if (empty($valuesEndereco['endereco_bairro'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe seu bairro',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($valuesEndereco['endereco_bairro']) > 200) || (strlen($valuesEndereco['endereco_bairro']) < 3)) {
            $_SESSION['msg'] = [
                'texto' => 'Limite de caracter não permitido para esse Bairro!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }


        // Validando a cidade
        if (empty($valuesEndereco['endereco_cidade'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe sua Cidade',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        if ((strlen($valuesEndereco['endereco_cidade']) > 100) || (strlen($valuesEndereco['endereco_cidade']) < 4)) {
            $_SESSION['msg'] = [
                'texto' => 'Limite de caracter não permitido para o campo Cidade!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }

        // Validando o UF
        if (empty($valuesEndereco['endereco_uf'])) {
            $_SESSION['msg'] = [
                'texto' => 'Informe o UF do seu estado!',
                'color' => 'danger',
            ];

            return $this->loadView('login/cadastroCliente', $data);
        }



        $this->endereco->insert($valuesEndereco);



        $valuesServico = [
            'servicos_nome'  => $post['servicos_nome'] ?? '',
            'servicos_data'  => $post['servicos_data'] ?? '',
            'servicos_valor' => $post['servicos_valor'] ?? '',
            'servicos_tipo_cobranca' => $post['servicos_tipo_cobranca'] ?? '',
            'servicos_nivel_experiencia' => $post['servicos_nivel_experiencia'] ?? '',
            'servicos_descricao' => $post['servicos_descricao'] ?? '',
            'servicos_usuarios_id' => $usuarioID
        ];

        if ($this->servico->insert($valuesServico)) {

            unset($_SESSION['cadastro_profissional']);
            unset($_SESSION['cadastro_profissional_imagem']);

            $_SESSION['msg'] = [
                'texto' => 'Usuário cadastrado com sucesso!',
                'color' => 'success',
            ];

            return $this->redirect(base_url('/login'));
        }
    }


    // Redireciona o usuario para a tela com os devidos dados
    public function editCliente($usuarios_id)
    {

        $data = [];
        $data['editarDados'] = ['Dados pessoais'];

        $pessoaFisica = $this->selectEditPF($usuarios_id);
        $pessoaJuridica = $this->selectEdiPJ($usuarios_id);

        if ($pessoaFisica) {
            $data['pessoaFisica'] = $pessoaFisica;

            return $this->loadView('user/homeCliente/editarPerfilPF', $data);
        }

        if ($pessoaJuridica) {
            $data['pessoaJuridica'] = $pessoaJuridica;

            return $this->loadView('user/homeCliente/editarPerfilPJ', $data);
        }
    }

    // Redireciona para a tela de editar dados - Profissional
    public function editProfissional($usuarios_id)
    {

        $data = [];
        $data['editarDados'] = ['Dados profissionais'];

        $pessoaFisica = $this->selectEditProfissionalPf($usuarios_id);
        $pessoaJuridica = $this->selectEditProfissionalPj($usuarios_id);

        if ($pessoaFisica) {
            $data['pessoaFisica'] = $pessoaFisica;

            return $this->loadView('user/homeProfissional/editarPerfilPF', $data);
        }

        if ($pessoaJuridica) {
            $data['pessoaJuridica'] = $pessoaJuridica;

            return $this->loadView('user/homeProfissional/editarPerfilPJ', $data);
        }
    }


    // Alteração de dados de pessoa Fisica para conta cliente
    public function AlterarDados($usuarios_id)
    {

        if (!isset($_FILES['usuarios_imagem']) || $_FILES['usuarios_imagem']['error'] == UPLOAD_ERR_NO_FILE) {
            $usuarios_imagem = $_SESSION['usuarios_logado']->usuarios_imagem;
        } else {

            $arquivo = $_FILES['usuarios_imagem'];

            // Verifica erro de upload
            if ($arquivo['error'] !== UPLOAD_ERR_OK) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao enviar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Tamanho máximo
            if (!$this->usuario->validaImagemPerfi($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve ter no máximo 2MB.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Tipo permitido
            if (!$this->usuario->tipoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'Formato inválido. Utilize JPG, JPEG ou PNG.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Dimensões mínimas
            if (!$this->usuario->tamanhoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve possuir no mínimo 400x400 pixels.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Pasta de destino
            $pasta = __DIR__ . '/../Public/template/UploadImages/';

            // Nome único
            $nomeArquivo = uniqid() . '-' . basename($arquivo['name']);

            $caminhoFinal = $pasta . $nomeArquivo;

            // Upload
            if (!move_uploaded_file($arquivo['tmp_name'], $caminhoFinal)) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao salvar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Exclui imagem antiga (se não for a padrão)
            if (
                !empty($usuarioAtual->usuarios_imagem) &&
                $usuarioAtual->usuarios_imagem !== 'UploadImages/default.png'
            ) {

                $imagemAntiga = __DIR__ . '/../' . $usuarioAtual->usuarios_imagem;

                if (file_exists($imagemAntiga)) {
                    unlink($imagemAntiga);
                }
            }

            // Caminho que será salvo no banco
            $usuarios_imagem = 'Public/template/UploadImages/' . $nomeArquivo;
        }

        $valuesUsuarios = [
            'usuarios_imagem' => $usuarios_imagem,
            'usuarios_telefone' => $_POST['usuarios_telefone'],
        ];

        $whereUsuarios = "usuarios_id = '$usuarios_id'";

        if (!$this->usuario->update($whereUsuarios, $valuesUsuarios)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesPessoaFisica = [
            'pf_nome' => $_POST['pf_nome'],
            'pf_sobrenome' => $_POST['pf_sobrenome'],
            'pf_dataNascimento' => $_POST['pf_dataNascimento'],
            'pf_genero'        => $_POST['pf_genero'],
        ];

        $wherePF = "pf_usuarios_id = '$usuarios_id'";

        if (!$this->pessoaFisica->update($wherePF, $valuesPessoaFisica)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesEndereco = [
            "endereco_nome" => $_POST['endereco_nome'],
            "endereco_rua" => $_POST['endereco_rua'],
            "endereco_bairro" => $_POST['endereco_bairro'],
            "endereco_cep" => $_POST['endereco_cep'],
            "endereco_complemento" => $_POST['endereco_complemento'],
            "endereco_numero" => $_POST['endereco_numero'],
            "endereco_descricao" => $_POST['endereco_descricao'],
            "endereco_cidade" => $_POST['endereco_cidade'],
            "endereco_uf" => $_POST['endereco_uf'],
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);


        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];
        }

        $_SESSION['msg'] = [
            'texto' => "Dados alterado com sucesso!",
            'color' => "success",
        ];

        return $this->editCliente($usuarios_id);
    }

    // Alteração de dados de pessoa juridica para conta clinete
    public function AlterarDadosPJ($usuarios_id)
    {

        if (!isset($_FILES['usuarios_imagem']) || $_FILES['usuarios_imagem']['error'] == UPLOAD_ERR_NO_FILE) {
            $usuarios_imagem = $_SESSION['usuarios_logado']->usuarios_imagem;
        } else {

            $arquivo = $_FILES['usuarios_imagem'];

            // Verifica erro de upload
            if ($arquivo['error'] !== UPLOAD_ERR_OK) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao enviar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Tamanho máximo
            if (!$this->usuario->validaImagemPerfi($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve ter no máximo 2MB.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Tipo permitido
            if (!$this->usuario->tipoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'Formato inválido. Utilize JPG, JPEG ou PNG.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Dimensões mínimas
            if (!$this->usuario->tamanhoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve possuir no mínimo 400x400 pixels.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Pasta de destino
            $pasta = __DIR__ . '/../Public/template/UploadImages/';

            // Nome único
            $nomeArquivo = uniqid() . '-' . basename($arquivo['name']);

            $caminhoFinal = $pasta . $nomeArquivo;

            // Upload
            if (!move_uploaded_file($arquivo['tmp_name'], $caminhoFinal)) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao salvar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editCliente($usuarios_id);
            }

            // Exclui imagem antiga (se não for a padrão)
            if (
                !empty($usuarioAtual->usuarios_imagem) &&
                $usuarioAtual->usuarios_imagem !== 'UploadImages/default.png'
            ) {

                $imagemAntiga = __DIR__ . '/../' . $usuarioAtual->usuarios_imagem;

                if (file_exists($imagemAntiga)) {
                    unlink($imagemAntiga);
                }
            }

            // Caminho que será salvo no banco
            $usuarios_imagem = 'Public/template/UploadImages/' . $nomeArquivo;
        }

        $valuesUsuarios = [
            'usuarios_imagem' => $usuarios_imagem,
            'usuarios_telefone' => $_POST['usuarios_telefone'],
        ];

        $whereUsuarios = "usuarios_id = '$usuarios_id'";

        if (!$this->usuario->update($whereUsuarios, $valuesUsuarios)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesPessoaJuridica = [
            'pj_razaoSocial' => $_POST['pj_razaoSocial'],
            'pj_nomeFantasia' => $_POST['pj_nomeFantasia'],
            'pj_dataFundacao' => $_POST['pj_dataFundacao'],
        ];

        $wherePF = "pj_usuarios_id = '$usuarios_id'";

        if (!$this->pessoaJuridica->update($wherePF, $valuesPessoaJuridica)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesEndereco = [
            "endereco_nome" => $_POST['endereco_nome'],
            "endereco_rua" => $_POST['endereco_rua'],
            "endereco_bairro" => $_POST['endereco_bairro'],
            "endereco_cep" => $_POST['endereco_cep'],
            "endereco_complemento" => $_POST['endereco_complemento'],
            "endereco_numero" => $_POST['endereco_numero'],
            "endereco_descricao" => $_POST['endereco_descricao'],
            "endereco_cidade" => $_POST['endereco_cidade'],
            "endereco_uf" => $_POST['endereco_uf'],
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);


        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];
        }

        $_SESSION['msg'] = [
            'texto' => "Dados alterado com sucesso!",
            'color' => "success",
        ];

        return $this->editCliente($usuarios_id);
    }




    // Alteração de dados de pessoa Fisica para conta Profissional
    public function AlterarDadosProfissionalPF($usuarios_id)
    {

        if (!isset($_FILES['usuarios_imagem']) || $_FILES['usuarios_imagem']['error'] == UPLOAD_ERR_NO_FILE) {
            $usuarios_imagem = $_SESSION['usuarios_logado']->usuarios_imagem;
        } else {

            $arquivo = $_FILES['usuarios_imagem'];

            // Verifica erro de upload
            if ($arquivo['error'] !== UPLOAD_ERR_OK) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao enviar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Tamanho máximo
            if (!$this->usuario->validaImagemPerfi($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve ter no máximo 2MB.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Tipo permitido
            if (!$this->usuario->tipoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'Formato inválido. Utilize JPG, JPEG ou PNG.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Dimensões mínimas
            if (!$this->usuario->tamanhoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve possuir no mínimo 400x400 pixels.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Pasta de destino
            $pasta = __DIR__ . '/../Public/template/UploadImages/';

            // Nome único
            $nomeArquivo = uniqid() . '-' . basename($arquivo['name']);

            $caminhoFinal = $pasta . $nomeArquivo;

            // Upload
            if (!move_uploaded_file($arquivo['tmp_name'], $caminhoFinal)) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao salvar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Exclui imagem antiga (se não for a padrão)
            if (
                !empty($usuarioAtual->usuarios_imagem) &&
                $usuarioAtual->usuarios_imagem !== 'UploadImages/default.png'
            ) {

                $imagemAntiga = __DIR__ . '/../' . $usuarioAtual->usuarios_imagem;

                if (file_exists($imagemAntiga)) {
                    unlink($imagemAntiga);
                }
            }

            // Caminho que será salvo no banco
            $usuarios_imagem = 'Public/template/UploadImages/' . $nomeArquivo;
        }

        $valuesUsuarios = [
            'usuarios_imagem' => $usuarios_imagem,
            'usuarios_telefone' => $_POST['usuarios_telefone'],
            'usuarios_atualizado_em' => date('Y-m-d H:i:s'),
        ];

        $whereUsuarios = "usuarios_id = '$usuarios_id'";

        if (!$this->usuario->update($whereUsuarios, $valuesUsuarios)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesPessoaFisica = [
            'pf_nome' => $_POST['pf_nome'],
            'pf_sobrenome' => $_POST['pf_sobrenome'],
            'pf_dataNascimento' => $_POST['pf_dataNascimento'],
            'pf_genero'        => $_POST['pf_genero'],
        ];

        $wherePF = "pf_usuarios_id = '$usuarios_id'";

        if (!$this->pessoaFisica->update($wherePF, $valuesPessoaFisica)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesEndereco = [
            "endereco_nome" => $_POST['endereco_nome'],
            "endereco_rua" => $_POST['endereco_rua'],
            "endereco_bairro" => $_POST['endereco_bairro'],
            "endereco_cep"     => $_POST['endereco_cep'],
            "endereco_complemento" => $_POST['endereco_complemento'],
            "endereco_numero" => $_POST['endereco_numero'],
            "endereco_descricao" => $_POST['endereco_descricao'],
            "endereco_cidade" => $_POST['endereco_cidade'],
            "endereco_uf" => $_POST['endereco_uf'],
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);


        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];
        }

        $valuesServicos = [
            'servicos_nome'                 => $_POST['servicos_nome'],
            'servicos_data'                 => $_POST['servicos_data'],
            'servicos_valor'                => $_POST['servicos_valor'],
            'servicos_tipo_cobranca'        => $_POST['servicos_tipo_cobranca'],
            'servicos_nivel_experiencia'    => $_POST['servicos_nivel_experiencia'],
            'servicos_descricao'            => $_POST['servicos_descricao']
        ];

        $whereServicos = "servicos_usuarios_id = '$usuarios_id'";

        $servicosUpdate = $this->servico->update($whereServicos, $valuesServicos);

        if (!$servicosUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];
        }




        $_SESSION['msg'] = [
            'texto' => "Dados alterado com sucesso!",
            'color' => "success",
        ];

        return $this->editProfissional($usuarios_id);
    }

    // Alteração de dados de pessoa juridica para conta clinete
    public function AlterarDadosProfissionalPJ($usuarios_id)
    {

        if (!isset($_FILES['usuarios_imagem']) || $_FILES['usuarios_imagem']['error'] == UPLOAD_ERR_NO_FILE) {
            $usuarios_imagem = $_SESSION['usuarios_logado']->usuarios_imagem;
        } else {

            $arquivo = $_FILES['usuarios_imagem'];

            // Verifica erro de upload
            if ($arquivo['error'] !== UPLOAD_ERR_OK) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao enviar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Tamanho máximo
            if (!$this->usuario->validaImagemPerfi($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve ter no máximo 2MB.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Tipo permitido
            if (!$this->usuario->tipoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'Formato inválido. Utilize JPG, JPEG ou PNG.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Dimensões mínimas
            if (!$this->usuario->tamanhoImagem($arquivo)) {

                $_SESSION['msg'] = [
                    'texto' => 'A imagem deve possuir no mínimo 400x400 pixels.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Pasta de destino
            $pasta = __DIR__ . '/../Public/template/UploadImages/';

            // Nome único
            $nomeArquivo = uniqid() . '-' . basename($arquivo['name']);

            $caminhoFinal = $pasta . $nomeArquivo;

            // Upload
            if (!move_uploaded_file($arquivo['tmp_name'], $caminhoFinal)) {

                $_SESSION['msg'] = [
                    'texto' => 'Erro ao salvar a imagem.',
                    'color' => 'danger'
                ];

                return $this->editProfissional($usuarios_id);
            }

            // Exclui imagem antiga (se não for a padrão)
            if (
                !empty($usuarioAtual->usuarios_imagem) &&
                $usuarioAtual->usuarios_imagem !== 'UploadImages/default.png'
            ) {

                $imagemAntiga = __DIR__ . '/../' . $usuarioAtual->usuarios_imagem;

                if (file_exists($imagemAntiga)) {
                    unlink($imagemAntiga);
                }
            }

            // Caminho que será salvo no banco
            $usuarios_imagem = 'Public/template/UploadImages/' . $nomeArquivo;
        }

        $valuesUsuarios = [
            'usuarios_imagem' => $usuarios_imagem,
            'usuarios_telefone' => $_POST['usuarios_telefone'],
        ];

        $whereUsuarios = "usuarios_id = '$usuarios_id'";

        if (!$this->usuario->update($whereUsuarios, $valuesUsuarios)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesPessoaJuridica = [
            'pj_razaoSocial' => $_POST['pj_razaoSocial'],
            'pj_nomeFantasia' => $_POST['pj_nomeFantasia'],
            'pj_dataFundacao' => $_POST['pj_dataFundacao'],
        ];

        $wherePF = "pj_usuarios_id = '$usuarios_id'";

        if (!$this->pessoaJuridica->update($wherePF, $valuesPessoaJuridica)) {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao alterar os dados!',
                'color' => 'danger',
            ];
        }

        $valuesEndereco = [
            "endereco_rua" => $_POST['endereco_rua'],
            "endereco_bairro" => $_POST['endereco_bairro'],
            "endereco_complemento" => $_POST['endereco_complemento'],
            "endereco_numero" => $_POST['endereco_numero'],
            "endereco_descricao" => $_POST['endereco_descricao'],
            "endereco_cidade" => $_POST['endereco_cidade'],
            "endereco_uf" => $_POST['endereco_uf'],
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);


        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];
        }


        $valuesServicos = [
            'servicos_nome'                 => $_POST['servicos_nome'],
            'servicos_data'                 => $_POST['servicos_data'],
            'servicos_valor'                => $_POST['servicos_valor'],
            'servicos_tipo_cobranca'        => $_POST['servicos_tipo_cobranca'],
            'servicos_nivel_experiencia'    => $_POST['servicos_nivel_experiencia'],
            'servicos_descricao'            => $_POST['servicos_descricao']
        ];

        $whereServicos = "servicos_usuarios_id = '$usuarios_id'";

        $servicosUpdate = $this->servico->update($whereServicos, $valuesServicos);

        if (!$servicosUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];
        }


        $_SESSION['msg'] = [
            'texto' => "Dados alterado com sucesso!",
            'color' => "success",
        ];

        return $this->editProfissional($usuarios_id);
    }


    // DESATIVAR CONTA DO USUARIO
    public function desativarConta($usuario_id)
    {
        $valuesExcluir = [
            'usuarios_ativo'   => 2,
            'usuarios_deletado_em' => date('Y-m-d H:i:s'),
        ];

        $whereUsuarios = "usuarios_id ='$usuario_id'";

        if (!$this->usuario->update($whereUsuarios, $valuesExcluir)) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível desativar sua conta, tente novamente!',
                'color' => 'danger',
            ];

            return $this->editCliente($usuario_id);
        }

        $_SESSION['msg'] = [
            'texto' => "Conta desativada com sucesso!",
            'color' => "success",
        ];

        return $this->login->index();
    }

    // Seleciona os dados de cliente pessoa fisica
    private function selectEditPF($usuarioID)
    {

        $join = "INNER JOIN endereco on endereco_usuarios_id = usuarios_id INNER JOIN pessoaFisica pf on pf.pf_usuarios_id = usuarios_id";
        $where = "usuarios_id = '$usuarioID'";

        return $this->usuario->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }

    // Seleciona os dados de cliente pessoa juridica
    private function selectEdiPJ($usuarioID)
    {

        $join = "INNER JOIN endereco on endereco_usuarios_id = usuarios_id INNER JOIN pessoaJuridica pj on pj.pj_usuarios_id = usuarios_id";
        $where = "usuarios_id = '$usuarioID'";

        return $this->usuario->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }


    // Seleciona os dados de profissional pessoa fisica
    private function selectEditProfissionalPf($usuarioID)
    {

        $join = "INNER JOIN endereco on endereco_usuarios_id = usuarios_id INNER JOIN pessoaFisica pf on pf.pf_usuarios_id = usuarios_id INNER JOIN servicos on servicos_usuarios_id = usuarios_id";
        $where = "usuarios_id = '$usuarioID'";

        return $this->usuario->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }

    // Seleciona os dados de profissional pessoa juridica
    private function selectEditProfissionalPj($usuarioID)
    {

        $join = "INNER JOIN endereco on endereco_usuarios_id = usuarios_id INNER JOIN pessoaJuridica pj on pj.pj_usuarios_id = usuarios_id INNER JOIN servicos on servicos_usuarios_id = usuarios_id";
        $where = "usuarios_id = '$usuarioID'";

        return $this->usuario->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }
}
