<?php
interface CryptoSigner{
//    public function load(string $path) : CryptoSigner;
    public static function load(string $path) : CryptoSigner;
    public function sign(string $privateKey, array $signerInfo) : void;
    public function verify(string $publicKey) : array;
    public function path() : string;
}