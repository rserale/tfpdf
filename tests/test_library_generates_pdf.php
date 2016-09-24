<?php

use PHPUnit\Framework\TestCase;

class tFPDFTest extends TestCase
{
   public function testCanBeNegated()
   {
      $pdfLibrary = new tFPDF\PDF();

      $pdfLibrary->AddPage();

      $pdfLibrary->SetFont('Courier', '', 14);

      $txt = file_get_contents(__DIR__ . '/test_data/HelloWorld.txt');
      $pdfLibrary->Write(8, $txt);

      $pdfLibrary->SetFont('Arial', '', 14);
      $pdfLibrary->Ln(10);
      $pdfLibrary->Write(5, "La taille de ce PDF n'est que de 12 ko.");

      $pdfLibrary->Output('output.pdf', __DIR__ . '/test_data/');
   }
}
