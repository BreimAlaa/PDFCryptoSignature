# PDFCryptoSignature
The PDF Crypto Signer Library is a PHP-based library that provides functionality for adding cryptographic signatures to PDF files and verifying existing signatures.

## Usage

### Generate Key Pair:
```
$keys = CryptoManager::generateKeyPair();
$publicKey = $keys['public_key'];
$privateKey = $keys['private_key'];
```

### Sign a PDF:

```
// Load the PDF and sign it
PDFCryptoSigner::load('signed.pdf')
    ->sign($privateKey);
```
You can also add extra information that you can retrive when verify the file:

```
PDFCryptoSigner::load('signed.pdf')
    ->sign($privateKey, [
        'issuer_name' => 'Alaa Breim',
        'issuer_email' => 'breim.alaa@gmail.com',
    ]);
```

### Verify a PDF Signature:
```
$verified = PDFCryptoSigner::load('signed.pdf')
    ->verify($publicKey);
```
the `verified` map will carry the isser data as will as the verification status
```
array(5) {
  ["issuer_name"]=>
  string(10) "Alaa Breim"
  ["issuer_email"]=>
  string(20) "breim.alaa@gmail.com"
  ["version"]=>
  int(1)
  ["date"]=>
  string(19) "2023-08-30 17:38:22"
  ["verified"]=>
  string(3) "Yes"
}
```
