<?php

require __DIR__ . '/vendor/autoload.php';



//var_dump(openssl_get_cert_locations());
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

// $id = $_GET["client_id"];s
// $secret = $_GET["client_secret"];
// $cert = $_GET["pix_cert"];
// $chave1 = $_GET["chave"];
// $valor = $_GET["valor"];

//$file = file_get_contents(__DIR__ . '/credentials.json');

$id = "Client_Id_6f2ecd3ec2de53490cc97447d22fa21eeddcbb21";
$secret = "Client_Secret_ae755e14a651dfdcec4a59003fdb2f67c9ea4428";
$cert = "producao-401337-slash.pem";
$valor = "00.01";
$expiracao = 3600;
$chave = "d285418e-80c8-41fb-a1d3-49a4c7ab6b10";

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

var_dump($options);

// Lê o arquivo json com suas credenciais
//$file = file_get_contents(__DIR__ . '/credentials.json');

// $id = "Client_Id_445881b4b865f3b89bcb8947f072de6cf8e70bb0";
// $secret = "Client_Secret_9540a3a26bc79b11f98a895fc455ef07f75c8a08";
// $cert = "./certs/homologacao-401337-teste2.pem";
// $valor = 10.00;
// $options = json_decode($file, true);
// $expiracao = 3600;


if (isset($_GET)) {

    $body = [
        "calendario" => [
            "expiracao" => $expiracao
        ],
        "valor" => [
            "original" => $valor
        ],
        "chave" => $chave, // Chave pix da conta Gerencianet do recebedor
        "infoAdicionais" => [
            [
                "nome" => "Karen Gabriella", // Nome do campo string (Nome) ≤ 50 characters
                "valor" => "00.01" // Dados do campo string (Valor) ≤ 200 characters
            ]
        ]
    ];

  

    try {
        $api = Gerencianet::getInstance($options);
       //echo 
        $pix = $api->pixCreateImmediateCharge([], $body);
        // echo $pix;
        if ($pix['txid']) {

            $params = [
                'id' => $pix['loc']['id']
            ];

            // Gera QRCode
            $qrcode = $api->pixGenerateQRCode($params);

            $return = [
                "code" => 200,
                "pix" => $pix,
                "qrcode" => $qrcode
            ];

           // echo json_encode($return);
			echo '<pre>';
            echo "id_transacao :" .$pix["txid"]."\r\n";
            echo "link :" .$qrcode["qrcode"]."\r\n";
            echo "imagem :" .$qrcode["imagemQrcode"];
			echo '</pre>';
        } else {
            echo json_encode($pix);
        }
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

// $items = [
//     [
//         'name' => 'Karen Gabriella',
//         'amount' => 1,
//         'value' => 1000
//     ],
//     [
//         'name' => 'Teste 2',
//         'amount' => 2,
//         'value' => 2000
//     ]
// ];

// $body = [
//     'items' => $items
// ];

// try {

//     $api = Gerencianet::getInstance($options);
//     $response = $api->createCharge([], $body);

//     echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
// } catch (GerencianetException $e) {
//     print_r($e->code);
//     print_r($e->error);
//     print_r($e->errorDescription);
// } catch (Exception $e) {
//     print_r($e->getMessage());
// }

//}


