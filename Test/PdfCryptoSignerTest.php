<?php
require_once 'Test.php';
require_once '../PDFCryptoSigner.php';
class PdfCryptoSignerTest extends Test{
    public function test_user_can_sign_pdf_document(): void
    {
        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->sign();

        if (file_exists('test.pdf')) {
            unlink('test.pdf');
        }
    }

    public function test_user_can_verify_signed_document(): void
    {
        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->sign();

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->verify();

        if (file_exists('test.pdf')) {
            unlink('test.pdf');
        }
    }

    public function test_user_can_not_verify_modified_document(): void
    {

        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->sign();

        file_put_contents('test.pdf', 'Hello World 2');

        $pdf = new PDFCryptoSigner('test.pdf');
        $response = $pdf->verify();
        $this->assertEquals($response['verified'], 'No');

        if (file_exists('test.pdf')) {
            unlink('test.pdf');
        }
    }

    public function test_user_can_get_issuer_data_from_signed_document(): void
    {
        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $issuer_data = [
            'Name' => 'Alaa',
            'Email' => 'breim.alaa@gmail.com',
        ];
        $pdf->sign($issuer_data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $response = $pdf->verify();

        foreach ($issuer_data as $key => $value) {
            $this->assertEquals($response[$key], $value);
        }
    }
}

