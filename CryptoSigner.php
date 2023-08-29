<?php
interface CryptoSigner{
//    public function load(string $path) : CryptoSigner;
    public static function load(string $path) : CryptoSigner;
    public function sign(array $signerInfo);
    public function verify() : array;
    public function path() : string;
}