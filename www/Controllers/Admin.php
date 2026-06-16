<?php


namespace Controllers;

use \Models\Database as Conexao;
use \PDO;

use \Utils\RenderView;

class Admin extends RenderView
{

    private $solicitacaoServico;
    private $usuarios;
    private $endereco;
    private $pessoaFisica;
    private $pessoaJuridica;
    private $servicos;


    public function __construct()
    {
        $this->solicitacaoServico = new Conexao('solicitacaoServico');
        $this->usuarios = new Conexao('usuarios');
        $this->endereco = new Conexao('endereco');
        $this->pessoaFisica = new Conexao('pessoaFisica');
        $this->pessoaJuridica = new Conexao('pessoaJuridica');
        $this->servicos = new Conexao('servicos');
    }



    public function index()
    {
        $data = [];
        $data['Admin'] = 'Administrador';

        $cliente = $this->contadorDeSolicitacoesDePF();
        $data['clienteAssiduo'] = $this->solicitacaoServico->selectProfissionais($cliente)->fetchAll(PDO::FETCH_OBJ);

        $profissional = $this->contadorDeSolicitacoesDeProfissional();
        $data['profissionalAssiduo'] = $this->solicitacaoServico->selectProfissionais($profissional)->fetchAll(PDO::FETCH_OBJ);

        $servico = $this->contadorDeServico();
        $data['servicos'] = $this->solicitacaoServico->selectProfissionais($servico)->fetchAll(PDO::FETCH_OBJ);


        return $this->loadView('adm/index', $data);
    }

    // Listar clientes
    public function listarClientes()
    {

        $tabelaCliente = $this->listasClientes();
        $data['listarClientes'] = $this->usuarios->selectProfissionais($tabelaCliente)->fetchAll(PDO::FETCH_OBJ);

        $tabelaClientePJ = $this->listasClientesPJ();
        $data['listarClientePJ'] = $this->usuarios->selectProfissionais($tabelaClientePJ)->fetchAll(PDO::FETCH_OBJ);

        return $this->loadView('adm/listaCliente', $data);
    }

    // LISTAR PROFISSIONAIS
    public function listarProfissional()
    {
        $tabelaProfissional = $this->listasProfissional();
        $data['listarProfissional'] = $this->usuarios->selectProfissionais($tabelaProfissional)->fetchAll(PDO::FETCH_OBJ);

        $tabelaProfissionalPJ = $this->listasProfissionalPJ();
        $data['listarProfissionalPJ'] = $this->usuarios->selectProfissionais($tabelaProfissionalPJ)->fetchAll(PDO::FETCH_OBJ);

        return $this->loadView('adm/listaProfissional', $data);
    }



    // Detalhar clientes pessoa fisica e juridica
    public function detalhes($usuariosID)
    {

        $data = [''];
        $data['detalhes'] = 'Detalhes cliente';

        $detalharUsuariosPF = $this->detalharUsuario($usuariosID);
        $data['detalharUsuariosPF'] = $detalharUsuariosPF;

        $detalharUsuarioPJ = $this->detalharUsuarioClientePj($usuariosID);
        $data['detalharUsuariosPj'] = $detalharUsuarioPJ;

        return $this->loadView('adm/detalhamento', $data);
    }


    // FUNÇAO PARA EDITAR CLIENTES DO TIPO PESSOA FISICA NA TELA DE DETALHAMENTO
    public function editarClientesPf($usuarios_id)
    {

        $detalharUsuariosPF = $this->detalharUsuario($usuarios_id);
        date_default_timezone_set('America/Sao_Paulo');


        $valuesUsuarios = [
            'usuarios_email' => $_POST['usuarios_email'],
            'usuarios_telefone' => $_POST['usuarios_telefone'],
            'usuarios_senha_hash' => !empty($_POST['usuarios_senha_hash']) ? password_hash($_POST['usuarios_senha_hash'], PASSWORD_DEFAULT) : $detalharUsuariosPF->usuarios_senha_hash,
            'usuarios_ativo' => $_POST['usuarios_ativo'],
            'usuarios_is_admin' => $_POST['usuarios_is_admin'],
            'usuarios_atualizado_em' => date('Y-m/d H:i:s'),
        ];

        $where = "usuarios_id = '$usuarios_id'";

        $usuariosUpdate = $this->usuarios->update($where, $valuesUsuarios);

        if (!$usuariosUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhes($usuarios_id);
        }

        $valuesEndereco = [
            "endereco_rua" => $_POST['endereco_rua'],
            "endereco_bairro" => $_POST['endereco_bairro'],
            "endereco_complemento" => $_POST['endereco_complemento'],
            "endereco_numero" => $_POST['endereco_numero'],
            "endereco_cidade" => $_POST['endereco_cidade'],
            "endereco_uf" => $_POST['endereco_uf']?? $detalharUsuariosPF->endereco_uf,
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);


        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhes($usuarios_id);
        }

        $valuesPessoaFisica = [
            "pf_nome" => $_POST['pf_nome'],
            "pf_sobrenome" => $_POST['pf_sobrenome'],
            "pf_genero" => $_POST['pf_genero'],
        ];

        $wherePF = "pf_usuarios_id = '$usuarios_id'";

        $PFUpdate = $this->pessoaFisica->update($wherePF, $valuesPessoaFisica);


        if (!$PFUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados da pessoa física deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhes($usuarios_id);
        }

        $_SESSION['msg'] = [
            'texto' => 'Usuário editado com sucesso!',
            'color' => 'success',
        ];

        return $this->detalhes($usuarios_id);
    }

    // Editar dados de pessoa juridica na tela de detalhamentos
    public function editarClientesPJ($usuarios_id)
    {

        $detalharUsuariosPJ = $this->detalharUsuarioClientePj($usuarios_id);
        date_default_timezone_set('America/Sao_Paulo');


        $valuesUsuarios = [
            'usuarios_email' => $_POST['usuarios_email'] ?? '',
            'usuarios_telefone' => $_POST['usuarios_telefone'] ?? '',
            'usuarios_senha_hash' => !empty($_POST['usuarios_senha_hash']) ? password_hash($_POST['usuarios_senha_hash'], PASSWORD_DEFAULT) : $detalharUsuariosPJ->usuarios_senha_hash,
            'usuarios_ativo' => $_POST['usuarios_ativo'] ?? '',
            'usuarios_is_admin' => $_POST['usuarios_is_admin'] ?? '',
            'usuarios_atualizado_em' => date('Y-m/d H:i:s'),
        ];

        $where = "usuarios_id = '$usuarios_id'";

        $usuariosUpdate = $this->usuarios->update($where, $valuesUsuarios);

        if (!$usuariosUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhes($usuarios_id);
        }

        $valuesEndereco = [
            "endereco_rua" => $_POST['endereco_rua'] ?? '',
            "endereco_bairro" => $_POST['endereco_bairro'] ?? '',
            "endereco_complemento" => $_POST['endereco_complemento'] ?? '',
            "endereco_numero" => $_POST['endereco_numero'] ?? '',
            "endereco_cidade" => $_POST['endereco_cidade'] ?? '',
            "endereco_uf" => $_POST['endereco_uf'] ?? '',
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);


        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhes($usuarios_id);
        }

        $valuesPessoaJuridica = [
            "pj_razaoSocial" => $_POST['pj_razaoSocial'] ?? '',
            "pj_nomeFantasia" => $_POST['pj_nomeFantasia'] ?? '',
        ];

        $wherePF = "pj_usuarios_id = '$usuarios_id'";

        $PFUpdate = $this->pessoaJuridica->update($wherePF, $valuesPessoaJuridica);


        if (!$PFUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados da pessoa jurídica deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhes($usuarios_id);
        }

        $_SESSION['msg'] = [
            'texto' => 'Usuário editado com sucesso!',
            'color' => 'success',
        ];

        return $this->detalhes($usuarios_id);
    }

    // DETALHAR PROFISSIONAL
    public function detalhesProfissional($usuariosID)
    {
        $data = [''];
        $data['detalhesP'] = 'Detalhes Profissional';

        $data['profissionalPF'] = $this->detalharProfissionalPF($usuariosID);
        $data['profissionalPJ'] = $this->detalharProfissionalPJ($usuariosID);


        return $this->loadView('adm/detalhamentoProfissional', $data);
    }

    // Editar profissional que é pessoa Fisica
    public function editarProfissionalPf($usuarios_id)
    {

        $detalharUsuariosPF = $this->detalharProfissionalPF($usuarios_id);
        date_default_timezone_set('America/Sao_Paulo');


        $valuesUsuarios = [
            'usuarios_email' => $_POST['usuarios_email'],
            'usuarios_telefone' => $_POST['usuarios_telefone'],
            'usuarios_senha_hash' => !empty($_POST['usuarios_senha_hash']) ? password_hash($_POST['usuarios_senha_hash'], PASSWORD_DEFAULT) : $detalharUsuariosPF->usuarios_senha_hash,
            'usuarios_ativo' => $_POST['usuarios_ativo'],
            'usuarios_is_admin' => $_POST['usuarios_is_admin'],
            'usuarios_atualizado_em' => date('Y-m-d H:i:s'),
        ];

        $where = "usuarios_id = '$usuarios_id'";

        $usuariosUpdate = $this->usuarios->update($where, $valuesUsuarios);

        if (!$usuariosUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }

        $valuesEndereco = [
            "endereco_rua" => $_POST['endereco_rua'],
            "endereco_bairro" => $_POST['endereco_bairro'],
            "endereco_complemento" => $_POST['endereco_complemento'],
            "endereco_numero" => $_POST['endereco_numero'],
            "endereco_cidade" => $_POST['endereco_cidade'],
            "endereco_uf" => !empty($_POST['endereco_uf']) ? $_POST['endereco_uf'] : $detalharUsuariosPF->endereco_uf,
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);

        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }


        $valuesServico = [
            "servicos_nome" => $_POST['servicos_nome'],
            "servicos_data" => $_POST['servicos_data'],
            "servicos_valor" => $_POST['servicos_valor'],
            "servicos_tipo_cobranca" => $_POST['servicos_tipo_cobranca'],
            "servicos_nivel_experiencia" => $_POST['servicos_nivel_experiencia'],
            "servicos_descricao" => $_POST['servicos_descricao'],
        ];

        $whereServico = "servicos_usuarios_id = '$usuarios_id'";

        $servicosoUpdate = $this->servicos->update($whereServico, $valuesServico);


        if (!$servicosoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }

        $valuesPessoaFisica = [
            "pf_nome" => $_POST['pf_nome'],
            "pf_sobrenome" => $_POST['pf_sobrenome'],
            "pf_genero" => $_POST['pf_genero'],
        ];

        $wherePF = "pf_usuarios_id = '$usuarios_id'";

        $PFUpdate = $this->pessoaFisica->update($wherePF, $valuesPessoaFisica);


        if (!$PFUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados da pessoa física deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }

        $_SESSION['msg'] = [
            'texto' => 'Usuário editado com sucesso!',
            'color' => 'success',
        ];

        return $this->detalhesProfissional($usuarios_id);
    }

    // Editar dados de pessoa juridica na tela de detalhamentos
    public function editarProfissionalPj($usuarios_id)
    {

        $detalharUsuariosPJ = $this->detalharProfissionalPJ($usuarios_id);
        date_default_timezone_set('America/Sao_Paulo');


        $valuesUsuarios = [
            'usuarios_email' => $_POST['usuarios_email'],
            'usuarios_telefone' => $_POST['usuarios_telefone'],
            'usuarios_senha_hash' => !empty($_POST['usuarios_senha_hash']) ? password_hash($_POST['usuarios_senha_hash'], PASSWORD_DEFAULT) : $detalharUsuariosPJ->usuarios_senha_hash,
            'usuarios_ativo' => $_POST['usuarios_ativo'],
            'usuarios_is_admin' => $_POST['usuarios_is_admin'],
            'usuarios_atualizado_em' => date('Y-m-d H:i:s'),
        ];

        $where = "usuarios_id = '$usuarios_id'";

        $usuariosUpdate = $this->usuarios->update($where, $valuesUsuarios);

        if (!$usuariosUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }

        $valuesEndereco = [
            "endereco_rua" => $_POST['endereco_rua'],
            "endereco_bairro" => $_POST['endereco_bairro'],
            "endereco_complemento" => $_POST['endereco_complemento'],
            "endereco_numero" => $_POST['endereco_numero'],
            "endereco_cidade" => $_POST['endereco_cidade'],
            "endereco_uf" => !empty($_POST['endereco_uf']) ? $_POST['endereco_uf'] : $detalharUsuariosPJ->endereco_uf,
        ];

        $whereEndereco = "endereco_usuarios_id = '$usuarios_id'";

        $enderecoUpdate = $this->endereco->update($whereEndereco, $valuesEndereco);


        if (!$enderecoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }

        $valuesPessoaJuridica = [
            "pj_razaoSocial" => $_POST['pj_razaoSocial'],
            "pj_nomeFantasia" => $_POST['pj_nomeFantasia'],
        ];

        $wherePF = "pj_usuarios_id = '$usuarios_id'";

        $PFUpdate = $this->pessoaJuridica->update($wherePF, $valuesPessoaJuridica);


        if (!$PFUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados da pessoa jurídica deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }

        $valuesServico = [
            "servicos_nome" => $_POST['servicos_nome'],
            "servicos_data" => $_POST['servicos_data'],
            "servicos_valor" => $_POST['servicos_valor'],
            "servicos_tipo_cobranca" => $_POST['servicos_tipo_cobranca'],
            "servicos_nivel_experiencia" => $_POST['servicos_nivel_experiencia'],
            "servicos_descricao" => $_POST['servicos_descricao'],
        ];

        $whereServico = "servicos_usuarios_id = '$usuarios_id'";

        $servicosoUpdate = $this->servicos->update($whereServico, $valuesServico);


        if (!$servicosoUpdate) {
            $_SESSION['msg'] = [
                'texto' => 'Não foi possível editar os dados de endereco deste usuários!',
                'color' => 'danger',
            ];

            return $this->detalhesProfissional($usuarios_id);
        }

        $_SESSION['msg'] = [
            'texto' => 'Usuário editado com sucesso!',
            'color' => 'success',
        ];

        return $this->detalhesProfissional($usuarios_id);
    }

    // Função para deletar usuarios na tela de detalhamentos, apenas adm
    public function excluirUsuario($usuariosID)
    {
        $valuesDeletarUsuario = [
            'usuarios_deletado_em' => date('Y-m-d H:i:s'),
            'usuarios_ativo'       => 0,
            'usuarios_is_admin'    => 0,
        ];

        $where = "usuarios_id = '$usuariosID'";

        if ($this->usuarios->update($where, $valuesDeletarUsuario)) {
            $_SESSION['msg'] = [
                'texto' => 'Usuário deletado com sucesso',
                'color' => 'success',
            ];
        } else {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao deletar o usuario',
                'color' => 'danger',
            ];
        }

        return $this->detalhes($usuariosID);
    }

    // Função para desfazer exclusão do usuário na tela de detalhamento, apenas adm
    public function desfazerExclusao($usuariosID)
    {

        $valuesDesfazerExclusao = [
            'usuarios_deletado_em' => '0000-00-00 00:00:00',
            'usuarios_ativo'       => 1,
            'usuarios_is_admin'    => 0,
        ];

        $where = "usuarios_id = '$usuariosID'";

        if ($this->usuarios->update($where, $valuesDesfazerExclusao)) {
            $_SESSION['msg'] = [
                'texto' => 'Exclusão desfeita com sucesso',
                'color' => 'success',
            ];
        } else {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao desfazer exclusão',
                'color' => 'danger',
            ];
        }

        return $this->detalhes($usuariosID);
    }

    // FUnção para excluir profissional na tela de detalhamento - apenas adm
    public function excluirUsuarioProfissional($usuariosID)
    {
        $valuesDeletarUsuario = [
            'usuarios_deletado_em' => date('Y-m-d H:i:s'),
            'usuarios_ativo'       => 0,
            'usuarios_is_admin'    => 0,
        ];

        $where = "usuarios_id = '$usuariosID'";

        if ($this->usuarios->update($where, $valuesDeletarUsuario)) {
            $_SESSION['msg'] = [
                'texto' => 'Usuário deletado com sucesso',
                'color' => 'success',
            ];
        } else {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao deletar o usuario',
                'color' => 'danger',
            ];
        }

        return $this->detalhesProfissional($usuariosID);
    }

    // Função para desfazer exclusão do usuário na tela de detalhamento, apenas adm
    public function desfazerExclusaoProfissional($usuariosID)
    {

        $valuesDesfazerExclusao = [
            'usuarios_deletado_em' => '0000-00-00 00:00:00',
            'usuarios_ativo'       => 1,
            'usuarios_is_admin'    => 0,
        ];

        $where = "usuarios_id = '$usuariosID'";

        if ($this->usuarios->update($where, $valuesDesfazerExclusao)) {
            $_SESSION['msg'] = [
                'texto' => 'Exclusão desfeita com sucesso',
                'color' => 'success',
            ];
        } else {
            $_SESSION['msg'] = [
                'texto' => 'Erro ao desfazer exclusão',
                'color' => 'danger',
            ];
        }

        return $this->detalhesProfissional($usuariosID);
    }

    // Contador de solicitaçoes de pessoas Fisicas
    private function contadorDeSolicitacoesDePF()
    {
        return "SELECT COUNT(solicitacaoServico_solicitacao_id) as total,
                CONCAT(pf_cliente.pf_nome, ' ', pf_cliente.pf_sobrenome)
                as nome,
                usuarios_imagem as usuariosImagem,
                usuarios_email as email

                from solicitacaoServico

                INNER JOIN solicitacao on solicitacao_id = solicitacaoServico_solicitacao_id
                INNER JOIN usuarios on usuarios_id = solicitacao_usuarios_id
                LEFT JOIN pessoaFisica pf_cliente on usuarios_id = pf_cliente.pf_usuarios_id

                WHERE pf_cliente.pf_tipo = 'Cliente' AND solicitacao_data >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                GROUP by usuarios_id
                ORDER BY total DESC
                LIMIT 5";
    }

    // Contador de pessoas JUridicas
    private function contadorDeSolicitacoesDeProfissional()
    {
        return "SELECT COUNT(solicitacaoServico_solicitacao_id) as total,
                pj_prof.pj_nomeFantasia as nome,
                usuarios_imagem as usuariosImagem,
                usuarios_email as email

                from solicitacaoServico

                INNER JOIN solicitacao on solicitacao_id = solicitacaoServico_solicitacao_id
                INNER JOIN usuarios on usuarios_id = solicitacao_usuarios_id
                LEFT JOIN pessoaJuridica pj_prof on usuarios_id = pj_prof.pj_usuarios_id

                WHERE pj_prof.pj_tipo = 'Cliente' AND solicitacao_data >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                GROUP by usuarios_id
                ORDER BY total DESC
                LIMIT 5";
    }

    // COntadro de serviços
    private function contadorDeServico()
    {
        return "SELECT COUNT(solicitacaoServico_servicos_id) as total,
                COALESCE(
                CONCAT(pf_prof.pf_nome, ' ', pf_prof.pf_sobrenome),
                pj_prof.pj_nomeFantasia) as nome,
                usuarios_imagem as usuariosImagem,
                usuarios_email as email,
                servicos_nome

                from solicitacaoServico

                INNER JOIN servicos on servicos_id = solicitacaoServico_servicos_id
                INNER JOIN usuarios on usuarios_id = servicos_usuarios_id
                LEFT JOIN pessoaJuridica pj_prof on usuarios_id = pj_prof.pj_usuarios_id
                LEFT JOIN pessoaFisica pf_prof on usuarios_id = pf_prof.pf_usuarios_id
                LEFT JOIN solicitacao on solicitacao_id = solicitacaoServico_solicitacao_id

                WHERE pj_prof.pj_tipo = 'Profissional' or pf_prof.pf_tipo = 'Profissional'  AND solicitacao_data >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                GROUP by usuarios_id
                ORDER BY total DESC
                LIMIT 5";
    }


    // Listar cliente pessoa fisica na tela de adm - clientes - pessoa fisica
    private function listasClientes()
    {
        return " SELECT
                *,
                CONCAT(pf_cliente.pf_nome, ' ', pf_cliente.pf_sobrenome
            ) AS nome,
            pf_cliente.pf_cpf AS documento,
            pf_cliente.pf_genero as genero
        FROM usuarios
        LEFT JOIN pessoaFisica pf_cliente
            ON usuarios_id = pf_cliente.pf_usuarios_id
        WHERE pf_cliente.pf_tipo = 'Cliente'
        ORDER BY nome ASC";
    }

    //  Listar clientes pessoa juridica na tela de adm - clientes - pessoa Jurdica
    private function listasClientesPJ()
    {
        return " SELECT
                *,
            pj_cliente.pj_razaoSocial AS nome,
            pj_cliente.pj_cnpj AS documento
        FROM usuarios
        LEFT JOIN pessoaJuridica pj_cliente
            ON usuarios_id = pj_cliente.pj_usuarios_id
        WHERE pj_cliente.pj_tipo = 'Cliente'
        ORDER BY nome ASC";
    }



    // Listar cliente pessoa fisica na tela de adm - Profissional - pessoa fisica
    private function listasProfissional()
    {
        return " SELECT
                *,
                CONCAT(pf_prof.pf_nome, ' ', pf_prof.pf_sobrenome
            ) AS nome,
            pf_prof.pf_cpf AS documento,
            pf_prof.pf_genero as genero
        FROM usuarios
        LEFT JOIN pessoaFisica pf_prof
            ON usuarios_id = pf_prof.pf_usuarios_id
        WHERE pf_prof.pf_tipo = 'Profissional'
        ORDER BY nome ASC";
    }

    //  Listar clientes pessoa juridica na tela de adm - clientes - pessoa Jurdica
    private function listasProfissionalPJ()
    {
        return " SELECT
                *,
            pj_prof.pj_razaoSocial AS nome,
            pj_prof.pj_cnpj AS documento
        FROM usuarios
        LEFT JOIN pessoaJuridica pj_prof
            ON usuarios_id = pj_prof.pj_usuarios_id
        WHERE pj_prof.pj_tipo = 'Profissional'
        ORDER BY nome ASC";
    }


    // Detalhar pessoa fisica tipo cliente
    private function detalharUsuario($usuarios_id)
    {

        $join = 'INNER JOIN pessoaFisica pf_cliente on pf_cliente.pf_usuarios_id = usuarios_id
        INNER JOIN endereco e on e.endereco_usuarios_id = usuarios_id';

        $where = "usuarios_id = '$usuarios_id'";


        return $this->usuarios->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }


    // Detalhar pessoa juridica tipo cliente
    private function detalharUsuarioClientePj($usuarios_id)
    {

        $join = 'INNER JOIN pessoaJuridica pj_cliente on pj_cliente.pj_usuarios_id = usuarios_id
        LEFT JOIN endereco e on e.endereco_usuarios_id = usuarios_id';

        $where = "usuarios_id = '$usuarios_id'";


        return $this->usuarios->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }


    // Profissional
    private function detalharProfissionalPF($usuarios_id)
    {

        $join = 'INNER JOIN pessoaFisica pf_prof on pf_prof.pf_usuarios_id = usuarios_id
        INNER JOIN endereco e on e.endereco_usuarios_id = usuarios_id INNER JOIN servicos on servicos_usuarios_id = usuarios_id';

        $where = "usuarios_id = '$usuarios_id'";


        return $this->usuarios->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }


    // Detalhar pessoa juridica tipo cliente
    private function detalharProfissionalPJ($usuarios_id)
    {

        $join = 'INNER JOIN pessoaJuridica pj_cliente on pj_cliente.pj_usuarios_id = usuarios_id
        LEFT JOIN endereco e on e.endereco_usuarios_id = usuarios_id INNER JOIN servicos on servicos_usuarios_id = usuarios_id';

        $where = "usuarios_id = '$usuarios_id'";


        return $this->usuarios->select($join, $where)->fetch(PDO::FETCH_OBJ);
    }
}
