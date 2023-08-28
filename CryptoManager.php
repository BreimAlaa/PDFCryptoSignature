<?php
class CryptoManager
{
    public function hash($data): string
    {
        return hash('sha3-512', $data);
    }

    public function base64Encode($data): string
    {
        return base64_encode($data);
    }

    public function base64Decode($data): string
    {
        return base64_decode($data);
    }

    public function generateKeyPair(): array
    {
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $privateKey);
        $publicKey = openssl_pkey_get_details($res);
        $publicKey = $publicKey["key"];
        return array(
            "privateKey" => $privateKey,
            "publicKey" => $publicKey
        );
    }

    public function sign($data, $privateKey): string
    {
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA512);
        return $signature;
    }
    public function verify($data, $signature, $publicKey): bool
    {
        return openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA512) === 1;
    }

    public function encrypt($data, $publicKey): string
    {
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return $encrypted;
    }
    public function decrypt($data, $privateKey): string
    {
        openssl_private_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }
    /**
     * @throws Exception
     */
    public static function __callStatic($name, $arguments): mixed
    {
        if (method_exists(CryptoManager::class, $name)) {
            return call_user_func_array([CryptoManager::class, $name], $arguments);
        }
        throw new Exception("Method $name does not exist.");
    }
}