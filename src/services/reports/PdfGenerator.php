<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\services\reports;


// require_once WP_PLUGIN_DIR . '/pdf-api/vendor/setasign/fpdf/fpdf.php';



class PdfGenerator{

  function __construct(){
    // echo '_PDF INICIADO';
  }

  public static function handle($request) {
    // Cria um novo documento PDF
    $pdf = new \FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Adiciona o texto "Hello World"
    $pdf->Cell(40, 10, 'Hello World');
    $pdf->Cell(40, 10, 'Vini 12');


    // Saída do PDF
    // Você pode querer salvar o PDF em um arquivo, ou talvez enviar diretamente como resposta
    // Neste exemplo, vou enviar o PDF diretamente como resposta

    // Configurar cabeçalhos para download do PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="hello_world.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');

    // Saída do PDF diretamente para o navegador
    $pdf->Output('I', 'hello_world.pdf');

    // Encerrar script para evitar enviar dados adicionais após o PDF
    exit;
  }

}

