<?php

require __DIR__ . '/vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

// Lê o arquivo json com suas credenciais
//$file = file_get_contents(__DIR__ . '/credentials.json');
// $txid = $_GET["id"];
// $id = $_GET["client_id"];
// $secret = $_GET["client_secret"];
// $cert = $_GET["pix_cert"];
// $chave = $_GET["chave"];
// $file = '{
//  	"client_id": "'.$id.'",
//     "client_secret": "'.$secret.'",
//     "pix_cert": "./certs/'.$cert.'",
//     "sandbox": false,
//     "timeout": 30
// }';



//echo $options;
// Lê o arquivo json com suas credenciais

//$file = file_get_contents(__DIR__ . '/credentials.json');

$id = "Client_Id_6f2ecd3ec2de53490cc97447d22fa21eeddcbb21";
$secret = "Client_Secret_ae755e14a651dfdcec4a59003fdb2f67c9ea4428";
$cert = "producao-401337-slash.pem";
$valor = "00.01";
$expiracao = 3600;
$chave = "41783264810";

// $contador = strlen($chave1);
// if($contador  == 13){
// $chave = "+".$chave1;	
// }else{
// $chave = $chave1;	
// }	

$file = '{
 	"client_id": "'.$id.'",
    "client_secret": "'.$secret.'",
    "pix_cert": "./certs/'.$cert.'",
    "sandbox": false,
    "timeout": 30
}';

$options = json_decode($file, true);

$params = ['txid' => $txid];

try {
    $api = Gerencianet::getInstance($options);
    $pix = $api->pixDetailCharge($params);

    //echo '<pre>' . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ;
	
	
	echo "Status: " . json_encode($pix["status"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
