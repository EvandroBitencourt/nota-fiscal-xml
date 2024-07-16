<?php

namespace src\controllers;

use \core\Controller;
use \src\models\Nota;

class HomeController extends Controller
{

    public function index()
    {
        $notas =  Nota::select()->execute();
        $this->render('home', [
            'notas' => $notas
        ]);
    }

    public function addNota()
    {
        $this->render('add_nota');
    }

    public function addAction()
    {

        $cnpj = filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_STRING);
        $cnpjValido = false;

        // Validação básica do CNPJ
        if ($cnpj && $cnpj === "09.066.241/0008-84") {
            $cnpjValido = true;
        }

        if ($cnpjValido) {
            // Diretório onde os arquivos serão salvos
            $pasta = "arquivos/";

            if ($_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {

                $nome = $_FILES['arquivo']['name'];
                $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                $formatosPermitidos = array("xml", "XML");

                if (in_array(strtolower($extensao), $formatosPermitidos)) {

                    move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . $nome);


                    $xmlPath = $pasta . $nome;
                    $xml = simplexml_load_file($xmlPath);


                    if ($xml !== false) {

                        $nf = (string) $xml->infNFe->ide->nNF;
                        $dataEmissao = (string) $xml->infNFe->ide->dhEmi;
                        $destinatario = (string) $xml->infNFe->dest->xNome;

                        // Obtém o valor total como string do XML
                        $valorTotalString = (string) $xml->infNFe->total->ICMSTot->vNF;

                        // Converte para float mantendo a formatação correta
                        $valorTotal = (float) str_replace(',', '.', $valorTotalString);

                        if (!empty($nf) && !empty($dataEmissao) && !empty($destinatario) && $valorTotal > 0) {

                            Nota::insert([
                                'destinatario' => $destinatario,
                                'num' => $nf,
                                'data' => $dataEmissao,
                                'valor' => number_format($valorTotal, 2, '.', '') // Formata o valor para 2 casas decimais com ponto como separador
                            ])->execute();

                            $_SESSION['message'] = 'Arquivo XML enviado e processado com sucesso.';
                        } else {
                            $_SESSION['message'] = 'Os dados do XML estão incompletos ou inválidos.';
                        }
                    } else {
                        $_SESSION['message'] = 'Erro ao processar o arquivo XML.';
                    }
                } else {
                    $_SESSION['message'] = 'Formato de arquivo não permitido. Envie um arquivo XML.';
                }
            } else {
                $_SESSION['message'] = 'Erro ao enviar o arquivo.';
            }
        } else {
            $_SESSION['message'] = 'CNPJ não é válido.';
        }

        $this->redirect('/new');
    }
}
