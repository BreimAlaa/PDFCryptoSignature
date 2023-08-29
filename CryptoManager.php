<?php

/**
 * @method static string hash(string $data)
 * @params string $data
 * @return string
 *
 * @method static string base64Encode(string $data)
 * @params string $data
 * @return string
 *
 * @method static string base64Decode(string $data)
 * @params string $data
 * @return string
 *
 * @method static array generateKeyPair() Generate public and private key pair
 * @return array
 *
 * @method static string sign(string $data, string $privateKey) Sign the data with private key
 * @params string $data
 * @params string $privateKey
 * @return string
 *
 * @method static bool verify(string $data, string $signature, string $publicKey) Verify the signature of data using the public key
 * @params string $data
 * @params string $signature
 * @params string $privateKey
 * @return bool
 * 
 * @method static string encrypt(string $data, string $privateKey) Encrypt data with private key
 * @params string $data
 * @params string $privateKey
 * @return string
 * 
 * @method static string decrypt(string $data, string $privateKey) Decrypt data with private key
 * @params string $data
 * @params string $privateKey
 * @return string
 *
 *
 * @method string hash(string $data)
 * @params string $data
 * @return string
 *
 * @method string base64Encode(string $data)
 * @params string $data
 * @return string
 *
 * @method string base64Decode(string $data)
 * @params string $data
 * @return string
 *
 * @method array generateKeyPair() Generate public and private key pair
 * @return array
 *
 * @method string sign(string $data, string $privateKey) Sign the data with private key
 * @params string $data
 * @params string $privateKey
 * @return string
 *
 * @method bool verify(string $data, string $signature, string $publicKey) Verify the signature of data using the public key
 * @params string $data
 * @params string $signature
 * @params string $privateKey
 * @return bool
 *
 * @method string encrypt(string $data, string $privateKey) Encrypt data with private key
 * @params string $data
 * @params string $privateKey
 * @return string
 *
 * @method string decrypt(string $data, string $privateKey) Decrypt data with private key
 * @params string $data
 * @params string $privateKey
 * @return string
 */

class CryptoManager
{
    private function hashForAlaa($data): string
    {
        return hash('sha3-512', $data);
    }

    private function base64EncodeForAlaa($data): string
    {
        return base64_encode($data);
    }

    private function base64DecodeForAlaa($data): string
    {
        return base64_decode($data);
    }

    private function generateKeyPairForAlaa(): array
    {
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $privateKey);
        $privateKey = openssl_pkey_get_details($res);
        $privateKey = $privateKey["key"];
        return array(
            "privateKey" => $privateKey,
            "privateKey" => $privateKey
        );
    }

    private function signForAlaa($data, $privateKey): string
    {
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA512);
        return $signature;
    }
    private function verifyForAlaa($data, $signature, $publicKey): bool
    {
        return openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA512) === 1;
    }

    private function encryptForAlaa($data, $privateKey): string
    {
        openssl_private_encrypt($data, $encrypted, $privateKey);
        return $encrypted;
    }
    private function decryptForAlaa($data, $privateKey): string
    {
        openssl_public_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }

    public static function __callStatic(string $name, array $arguments)
    {
        $instance = new static();
        $method = $name . 'ForAlaa';
        return $instance->$method(...$arguments);
    }

    public function __call(string $name, array $arguments)
    {
        $method = $name . 'ForAlaa';
        return $this->$method(...$arguments);
    }
}
