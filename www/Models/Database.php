<?php

namespace Models;

use \Pdo;
use \PDOException;

class Database
{


    const HOST = 'mysql_server';

    const NAME = 'LaborHUB';

    const USER = 'aluno';

    const PASS = '123456';

    const PORT = '3306';

    private ?string $tabela;

    private PDO $conection;


    public function __construct(?string $tabela = null)
    {
        $this->tabela = $tabela;
        $this->setConexao();
    }

    /**
     * Função para conectar no banco de dados
     * 
     */
    public function setConexao()
    {
        try {

            $this->conection = new PDO("mysql:host=" . self::HOST . ';dbname=' . self::NAME . ';port=' . self::PORT, self::USER, self::PASS);
            $this->conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("ERRO DE CONEXAO: " . $e->getMessage());
        }
    }

    // Função para executar as querys

    public function execute($query, $param = [])
    {
        try {
            $stmt = $this->conection->prepare($query);
            $stmt->execute($param);
            return $stmt;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * CRUD A SEGUIR - INSERT
     * 
     */

    public function insert($values)
    {

        $campo = array_keys($values); //Vai pegar a chave dos valores
        $posicao = array_pad([], count($values), '?'); //Vai verificar quantos elementos tem no array e vai contar a quantidade passando sobre elas o ponto de interrogação

        // Insert into <tabela> (campos que posição desta tabela) values (?) a quantidade de itens que tem dentro da tabela
        $query = "INSERT INTO " . $this->tabela . ' (' . implode(',', $campo) . ') VALUES (' . implode(',', $posicao) . ')';

        // Vai inserir os valores que foram passados na variavel $values
        $this->execute($query, array_values($values));

        // Retornamos o ultimo ID inserido
        return (int) $this->conection->lastInsertId();
    }

    // Validação da foto de perfil
    public function validaImagemPerfi(array $usuario_imagem)
    {

        // Se imagem for maior que 2MB - retornar falso pois não é permitido
        if ($usuario_imagem['size'] > (1024 * 1024 * 2)) {
            return false;
        } else {
            return true;
        }
    }

    // Validação dos tipos da imagem
    public function tipoImagem(array $usuario_imagem)
    {
        $tipoImagem = ['image/jpeg', 'image/png', 'image/jpg'];

        if (!in_array($usuario_imagem['type'], $tipoImagem)) {
            return false;
        } else {
            return true;
        }
    }

    // Verifica o tamanhao da imagem, se for menor que 400x400 não pode!
    public function tamanhoImagem(array $usuario_imagem)
    {
        $dimensao = getimagesize($usuario_imagem['tmp_name']);

        if ($dimensao[0] < 200 || $dimensao[1] < 200) {
            return false;
        } else {
            return true;
        }
    }



    public function select($join = null, $where = null, $order = null, $limit = null, $campo = '*')
    {

        $join = !empty($join) ?  $join : '';
        $where = !empty($where) ? "WHERE " . $where : '';
        $order = !empty($order) ? "ORDER BY " . $order : '';
        $limit = !empty($limit) ? "LIMIT " . $limit : '';


        $query = 'SELECT ' . $campo . ' FROM ' . $this->tabela . ' ' . $join . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function update($where, $values)
    {

        $fields = array_keys($values);


        $set = implode(' = ?, ', $fields) . ' = ?';
        $query = "UPDATE  {$this->tabela} SET {$set} WHERE {$where}";

        $this->execute($query, array_values($values));


        return true;
    }


    public function selectProfissionais($queryCustomizada)
    {

        return $this->execute($queryCustomizada);
    }


    // Altere a assinatura para aceitar o $params
    public function selectLogin($join = null, $where = null, $params = [], $order = null, $limit = null, $campo = '*')
    {
        $join = !empty($join) ? $join : '';
        $where = !empty($where) ? "WHERE " . $where : '';
        $order = !empty($order) ? "ORDER BY " . $order : '';
        $limit = !empty($limit) ? "LIMIT " . $limit : '';

        $query = "SELECT $campo FROM {$this->tabela} $join $where $order $limit";

        // Agora usamos o prepare e o execute do PDO para garantir a segurança
        $stmt = $this->conection->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }
}
