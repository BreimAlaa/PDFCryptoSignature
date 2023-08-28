<?php
interface EnhancedFile{
    public function load(string $path) : EnhancedFile;
    public function sign(array $signerInfo);
    public function verify() : array;
    public function path() : string;
}