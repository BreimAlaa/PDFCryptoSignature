<?php
interface EnhancedFile{
    public function load(string $path) : EnhancedFile;
    public function sign();
    public function verify() : array;
    public function path() : string;
}