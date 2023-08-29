<?php
require_once 'PDFCryptoSigner.php';
require_once 'CryptoManager.php';

$keys = CryptoManager::generateKeyPair();
$publicKey = $keys['public_key'];
$privateKey = $keys['private_key'];

copy('original.pdf', 'signed.pdf');

PDFCryptoSigner::load('signed.pdf')
    ->sign($privateKey, [
        'name' => 'Alaa Breim',
        'email' => 'breim.alaa@gmail.com',
        ]);

$verified = PDFCryptoSigner::load('signed.pdf')
    ->verify($publicKey);

var_dump($verified);

unlink('signed.pdf');
