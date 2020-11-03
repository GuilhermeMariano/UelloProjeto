<?php

	//CONEXÃO
	include_once("conexao.php");


	//recebendo arquivo
	$arquivo  = $_FILES["file"]["tmp_name"];

	// nome do arquivo
	$nome  = $_FILES["file"]["name"];

	//transforma no array onde encontrar o ponto
	$ext = explode(".",$nome);
	//nome do arquivo[0].csv[1]

	//pegar ultima posição do array
	$extensão = end($ext);
	// verificar se extensão é valida
	if($extensão != "csv"){
		echo "Extensão Inválida";
	}else{
		// fopen = função pra ler o arquivo / 'r' = ler
		$objeto = fopen($arquivo, 'r');

		//fazer looping delimitando por ;
		while(($dados = fgetcsv($objeto, 1000, ";") ) !== FALSE)
		{
			$nome  = utf8_encode($dados[0]);
			$sobrenome  = utf8_encode($dados[1]);
			$datanascimento  = utf8_encode($dados[2]);
			$cpf  = utf8_encode ($dados[3]);
			$logradouro  = utf8_encode($dados[4]);
			$numero  = utf8_encode($dados[5]);
			$complemento  = utf8_encode($dados[6]);
			$bairro  = utf8_encode($dados[7]);
			$cep   = utf8_encode ($dados[8]);
			$cidade  = utf8_encode($dados[9]);
			$cpfcli  = utf8_encode ($dados[10]);

			// fazendo a inserção no banco
			$result = $conn->query("INSERT INTO cliente (nome,email,data_nascimento,cpf) values ('$nome','$sobrenome','$datanascimento','$cpf')");
			$result2 = $conn->query("INSERT INTO endereco (logradouro,numero,complemento,bairro,cep,cidade,cpfcli) values ('$logradouro','$numero','$complemento','$bairro','$cep','$cidade','$cpfcli')");

		}

		if ($result and $result2){
			echo "Os dados foram inseridos com sucesso!"."<br>"."<br>";

		}else{
			echo "Erro ao inserir os dados"."<br>"."<br>";
		} 


	}	

	// fazendo a query para pode extrair os dados e visualizar na tela
	$consulta = "SELECT
           nome
           ,email
           ,data_nascimento
           ,cpf
           ,aux.logradouro
           ,aux.numero
           ,aux.complemento
           ,aux.bairro
           ,aux.cep
           ,aux.cidade
           FROM cliente c LEFT JOIN (select DISTINCT
           logradouro
           ,numero
           ,complemento
           ,bairro
           ,cep
           ,cidade
           ,cpfcli from endereco) aux on c.cpf = aux.cpfcli";
           // variavel $con armazena a consulta
	$con = $conn->query($consulta) or die ($conn->error);
?>



<html>

		<head>
  			<meta charset="utf-8">
		</head>
		<body>
			<table border="1">
				<tr> 
					<td>Nome</td>
					<td>Email</td>
					<td>Data de Nascimento</td>
					<td>CPF</td>
					<td>Logradouro</td>
					<td>Numero</td>
					<td>Complemento</td>
					<td>Bairro</td>
					<td>Cep</td>
					<td>Cidade</td>
				</tr>
				<!-- $dado recebe a consulta e o fecth_array percorre os dados do banco  --> 
				<?php while ($dado = $con->fetch_array()){ ?>
				<tr>
					<td><?php echo $dado ["nome"];?></td>
					<td><?php echo $dado ["email"];?></td>
					<td><?php echo $dado ["data_nascimento"];?></td>
					<td><?php echo $dado ["cpf"];?></td>
					<td><?php echo $dado ["logradouro"];?></td>
					<td><?php echo $dado ["numero"];?></td>
					<td><?php echo $dado ["complemento"];?></td>
					<td><?php echo $dado ["bairro"];?></td>
					<td><?php echo $dado ["cep"];?></td>
					<td><?php echo $dado ["cidade"];?></td>	
				</tr>	
				<?php } ?> 
			</table>
		</body>

  		<h2>Uello</h2>
  		<form action = "Exportar.php" method= "post" enctype=>
    	</div> 
   		<button type="submit" class="btn btn-default">Exportar</button>
</html>