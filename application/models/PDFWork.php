<?php
require_once 'MyPDF/mpdf.php';

class Application_Model_PDFWork
{

    private $My_PDF;

    public function __construct ()
    {
        $this->My_PDF = new mPDF('utf-8', 'A4');
    }

    public function My_create_PDF ($html)
    {
        $this->My_PDF->WriteHTML($html);
        $this->My_PDF->Output("test_pdf.pdf", "I");
    }
}