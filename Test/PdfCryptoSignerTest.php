<?php
require_once 'Test.php';
require_once '../PDFCryptoSigner.php';
class PdfCryptoSignerTest extends Test{

    private string $publicKey;
    private string $privateKey;

    public function __construct()
    {
        $keys = CryptoManager::generateKeyPair();
        $this->publicKey = $keys['public_key'];
        $this->privateKey = $keys['private_key'];
    }

    public function test_user_can_sign_pdf_document(): void
    {
        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        
        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->sign($this->privateKey);

        if (file_exists('test.pdf')) {
            unlink('test.pdf');
        }
    }

    public function test_user_can_verify_signed_document(): void
    {
        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->sign($this->privateKey);

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->verify($this->publicKey);

        if (file_exists('test.pdf')) {
            unlink('test.pdf');
        }
    }

    public function test_user_can_not_verify_modified_document(): void
    {

        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->sign($this->privateKey);

        file_put_contents('test.pdf', 'Hello World 2');

        $pdf = new PDFCryptoSigner('test.pdf');
        $response = $pdf->verify($this->publicKey);
        $this->assertEquals($response['verified'], 'No');

        if (file_exists('test.pdf')) {
            unlink('test.pdf');
        }
    }

    public function test_user_can_get_issuer_data_from_signed_document(): void
    {

        if (file_exists('test.pdf')) {
            unlink('test.pdf');
        }
        $data = 'Hello World';
        file_put_contents('test.pdf', $data);

        $pdf = new PDFCryptoSigner('test.pdf');
        $issuer_data = [
            'Name' => 'Alaa',
            'Email' => 'breim.alaa@gmail.com',
        ];

        $pdf = new PDFCryptoSigner('test.pdf');
        $pdf->sign($this->privateKey, $issuer_data);


        $pdf = new PDFCryptoSigner('test.pdf');
        $response = $pdf->verify($this->publicKey);

        foreach ($issuer_data as $key => $value) {
            if (!isset($response[$key])) throw new Exception('Issuer data not found');
            $this->assertEquals($response[$key], $value);
        }
    }
}

