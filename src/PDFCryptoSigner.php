<?php
require_once 'CryptoSigner.php';
require_once 'PDFValidator.php';
class PDFCryptoSigner implements CryptoSigner
{
    private $path;

    /**
     * @throws Exception
     */
    public function __construct(string $path = null)
    {
        if ($path !== null) {
            $this->loadFile($path);
        }
    }

    /**
     * @throws Exception
     */
    public function loadFile($path): CryptoSigner
    {
        $this->path = $path;

        PDFValidator::validate($this);

        return $this;
    }
    /**
     * @throws Exception
     */
    public static function load($path): CryptoSigner
    {
        $enhancedPDF = new self($path);
        PDFValidator::validate($enhancedPDF);

        return $enhancedPDF;
    }

    public function sign(string $privateKey, array $signerInfo = []): void
    {
        $content = file_get_contents($this->path);
        $base64File = CryptoManager::base64Encode($content);
        $hashed = CryptoManager::hash($base64File);
        $signed = CryptoManager::sign($hashed, $privateKey);

        $signerInfo['version'] = 1;
        $signerInfo['date'] = date('Y-m-d H:i:s');

        $headers = json_encode($signerInfo);
        $base64Headers = CryptoManager::base64Encode($headers);
        $encryptedHeaders = CryptoManager::encrypt($base64Headers, $privateKey);

        $comment = '7PI' . $signed . '7PI' . $encryptedHeaders;

        $modifiedPDFContent = $content . '\n' . '% ' . $comment;

        file_put_contents($this->path, $modifiedPDFContent);
    }

    public function verify(string $publicKey): array
    {
        try {
            $content = file_get_contents($this->path);
            $file = explode('\n', $content);
            $signatures = end($file);
            $signatures = substr($signatures, 2);
            array_pop($file);
            $file = implode('\n', $file);


            $base64File = CryptoManager::base64Encode($file);
            $hashed = CryptoManager::hash($base64File);

            $explodedSignature = explode('7PI', $signatures);
            if (count($explodedSignature) !== 3) {
                throw new Exception('Invalid signature');
            }
            $fileSignature = $explodedSignature[1];
            $encryptedHeaders = $explodedSignature[2];

            $headers['verified'] = CryptoManager::verify($hashed, $fileSignature, $publicKey);
            if ($headers['verified']){
                $headers = array_merge($headers, json_decode(CryptoManager::base64Decode(CryptoManager::decrypt($encryptedHeaders, $publicKey)), true));
            }

        } catch (Exception $e) {
            $headers = ['verified' => false];
        }
        return $headers;
    }

    public function path(): string
    {
        return $this->path;
    }

}