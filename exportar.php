<?php

// incluindo a conexão
include_once("conexao.php");




//criando o conjunto de valores a ser gravado
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

    //jogando na variavel $con
   $con = $conn->query($consulta) or die ($conn->error);





//definindo o nome do arquivo e abrindo o mesmo para escrita (write)
$fp = fopen("TabelasUello.csv", 'w');

//percorrendo o conjunto de valores e gravando no arquivo
foreach ($con as $linha) {
    fputcsv($fp, $linha,";");
}
//fechando o arquivo
fclose($fp);
echo "Arquivo Gerado com Sucesso";