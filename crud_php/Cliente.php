<?php

	class Cliente{

		private $conexao = NULL;

		//Conexão com o banco de dados
		public function __construct(){
			try{
				//usa a variavel this->conexao para fazer as açoes no BD($this->conexao->query(Insert into cliente() values ())
	        	$this->conexao = new PDO("mysql:host=localhost;dbname=novo_php", "root", "");
	        	$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        }catch(PDOException $e){
	        	echo $e->getMessage();
	        }
    	}

 #----------------------------------------------------Inserir elementos-------------------------------------------------#
    	public function inserir($nome, $email, $telefone){
    		try{//prepara o cadastro
    			$inserir = $this->conexao->prepare('INSERT INTO cliente(nome, email, telefone) VALUES (:nome, :email, :telefone)');
				$inserir->bindValue(":nome", $nome);//bindValue substitui os valores e manda pro BD
				$inserir->bindValue(":email", $email);
				$inserir->bindValue(":telefone", $telefone);
				//Validar cadastro
				
					$criar = $inserir->execute();//executa a query e atribui a variavel criar, o resultado booleano
				
					if($criar){
	                	return true;
	            	}
            		return false;
				
    		}catch(PDOException $e){
            	return $e->getMessage();
            }
    	}

  #----------------------------------------------------Listar elementos-------------------------------------------------#
    	
    	public function lista(){
	    	$consulta = $this->conexao->query("SELECT * FROM cliente ORDER by id DESC ");
	        $lista = array();
	        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
	        	//pega os dados da variavel $linha e atribui ao array $lista
	            array_push($lista, $linha);
	        }
	        return $lista;
	    }

  #----------------------------------------------------Pegar ID-------------------------------------------------#

	    public function getId($id){
	    	$stmt = $this->conexao->prepare("SELECT * FROM cliente WHERE id=:id");
		    $stmt->execute(array(":id"=>$id));
		    $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		    return $editRow;
	    }


  
  #----------------------------------------------------Alterar elementos-------------------------------------------------#

  //$consulta = $this->conexao->prepare("SELECT * FROM clientes where id = :id ");Busca segura... com doi pontos :

    	public function alterar($id, $nome, $email, $telefone){
    		try{
    			
    		 	$alterar = $this->conexao->prepare("UPDATE cliente SET nome=:nome, 
                                                 $email=:email, telefone=:telefone WHERE id=:id ");
	            $alterar->execute(array(
				    ':id'   => $id,
				    ':nome' => $nome,
				    ':email' => $email,
				    ':telefone' => $telefone
				));
            	return $alterar;
    		}catch(PDOException $e){
            	return $e->getMessage();
            	return false;
    		}
    	}

   #----------------------------------------------------Deletar elementos-------------------------------------------------#
    	public function deletar($id){
	        try{
	            $sql = "DELETE FROM cliente WHERE id = ".$id;
	            if($this->conexao->query($sql)){
	                $msg = "Deletado com sucesso!";
	            }else{
	                $msg = "Erro ao deletar!";
	            }
	            $this->conexao = null;
	            return $msg;
	        }catch (PDOException $e){
	            $e->getMessage();
	        }
    	}
	}

?>