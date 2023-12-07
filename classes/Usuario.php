<?php

include('conexao/conexao.php');

$db = new Conexao();

class Usuario
{
    public $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar($nome, $email, $senha, $confSenha, $cep, $rua, $numero_casa)
    {

        if ($senha == $confSenha) {

            $emailExistente = $this->verificacaoEmailExistente($email);
            if ($emailExistente) {
                print "<script>alert('Email já cadastrado')</script>";
                return false;
            }

            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nome, email, senha, cep, rua, numero_casa) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $senhaCriptografada);
            $stmt->bindValue(4, $cep);
            $stmt->bindValue(5, $rua);
            $stmt->bindValue(6, $numero_casa);
            $result = $stmt->execute();

            return $result;
        } else {
            return false;
        }
    }

    public function updateUser($postValues)
    {
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $email = $postValues['email'];
        $cep = $postValues['cep'];
        $rua = $postValues['rua'];
        $numero_casa = $postValues['numero_casa'];

        // Verifica se algum dos campos está vazio
        if (empty($id) || empty($nome) || empty($email) || empty($cep) || empty($rua) || empty($numero_casa)) {
            return false;
        }

        // Prepara a consulta SQL para atualizar um produtos
        $query = "UPDATE usuarios SET nome = ?, email = ?, cep=?, rua=?, numero_casa=? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $cep);
        $stmt->bindParam(4, $rua);
        $stmt->bindParam(5, $numero_casa);
        $stmt->bindParam(6, $id);

        // Verifica se o email já existe
        $emailexistente = $this->verificacaoEmail($email, $id);
        if ($emailexistente) {
            print "<script>alert('Já existe esse email de produto registrado.')</script>";
            return false;
        }

        // Executa a consulta SQL de atualização
        else if ($stmt->execute()) {
            print "<script>alert('Altualizado com sucesso!')</script>";
            return true;
        } else {
            return false;
        }
    }

    

    private function verificacaoEmail($email, $id)
    {
        $sql = "SELECT COUNT(*) from usuarios WHERE email = ? AND id <> ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $id);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function readOne($id)
    {
        // Prepara a consulta SQL para selecionar um user com base no id
        $query = "SELECT nome, email, cep, rua, numero_casa FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    private function verificacaoEmailExistente($email)
    {
        $sql = "SELECT COUNT(*) from usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function logar($email, $senha)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $usuario['senha'])) {
                return true;
            }
        }
    }

    public function getDadosUsuario($email)
    {
        $sql = "SELECT id,nome FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verificarAdm($login)
    {
        $query = "SELECT adm FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $login);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario['adm'] == 1;
        }

        return false;
    }
}
