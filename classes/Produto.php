<?php

include('conexao/conexao.php');

$db = new Conexao();

class CrudProduto
{
    private $conn;
    private $table_name ="produtos";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($postValue)
    {
        $nome_produto = $postValue['nome_produto'];
        $tipo = $postValue['tipo'];
        $descricao = $postValue['descricao'];
        $preco = $postValue['preco'];
        $destaque = $postValue['destaque'];


        if (isset($_FILES['foto_produto'])) {
            $arquivo = $_FILES['foto_produto'];
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $ex_permitidos = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array(strtolower($extensao), $ex_permitidos)) {
                $caminho_arquivo = 'foto_produto/' . $arquivo['name'];
                move_uploaded_file($arquivo['tmp_name'], $caminho_arquivo);
            } else {
                die('Você não pode fazer upload desse tipo de arquivo');
            }
        } else {
            $caminho_arquivo = ''; // Se nenhum arquivo foi enviado, defina o caminho como vazio
        }


        $query = "INSERT INTO produtos (nome_produto, tipo, descricao,preco,destaque, foto_produto) VALUES (?,?,?,?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome_produto);
        $stmt->bindParam(2, $tipo);
        $stmt->bindParam(3, $descricao);
        $stmt->bindParam(4, $preco);
        $stmt->bindParam(5, $destaque);
        $stmt->bindParam(6, $caminho_arquivo);


        $rows = $this->read();
        if ($stmt->execute()) {
            print "<script> alert('Cadastro realizado com sucesso!!! ')</script>";
            print "<script>  location.href='?action=read';</script>";
            return true;
        } else {
            return false;
        }
    }

    public function read()
    {
        $query = "SELECT * FROM produtos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updateProduct($postValues)
    {
        $id_produto = $postValues['id_produto'];
        $nome_produto = $postValues['nome_produto'];
        $descricao = $postValues['descricao'];
        $tipo = $postValues['tipo'];
        $preco = $postValues['preco'];
        $destaque = $postValues['destaque'];

        // Verifica se algum dos campos está vazio
        if (empty($id_produto) || empty($nome_produto) || empty($descricao) || empty($tipo) || empty($preco)) {
            return false;
        }

        // Prepara a consulta SQL para atualizar um produtos
        $query = "UPDATE " . $this->table_name . " SET nome_produto = ?, descricao = ?, preco = ?, tipo = ?,  destaque = ? WHERE id_produto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome_produto);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $preco);
        $stmt->bindParam(4, $tipo);
        $stmt->bindParam(5, $destaque);
        $stmt->bindParam(6, $id_produto);

        // Verifica se o descricao já existe
        $nomeexistente = $this->verificacaoNome($nome_produto, $id_produto);
        if ($nomeexistente) {
            print "<script>alert('Já existe esse nome de produto registrado.')</script>";
            return false;
        }

        // Executa a consulta SQL de atualização
        else if ($stmt->execute()) {
            print "<script>alert('Altualizado com sucesso!')</script>";
            print "<script> location.href='?action=read'; </script>";
            return true;
        } else {
            return false;
        }
    }

    public function readOne($id_produto)
    {
        // Prepara a consulta SQL para selecionar um produto com base no id_produto
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_produto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_produto);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Funcão para apagar os registro
    public function delete($id_produto)
    {
        // Prepara a consulta SQL para excluir um produtos com base no id_produto
        $query = "DELETE FROM " . $this->table_name . " WHERE id_produto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_produto);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function verificacaoNome($nome_produto, $id_produto)
    {
        $sql = "SELECT COUNT(*) from produtos WHERE nome_produto = ? AND id_produto <> ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $nome_produto);
        $stmt->bindParam(2, $id_produto);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
}
