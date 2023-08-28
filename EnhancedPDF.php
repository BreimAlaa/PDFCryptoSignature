<?php
require 'EnhancedFile.php';
require 'PDFValidator.php';
class EnhancedPDF implements EnhancedFile
{
    private $path;

    /**
     * @throws Exception
     */
    public function __construct(string $path = null)
    {
        if ($path !== null) {
            $this->load($path);
        }
    }

    /**
     * @throws Exception
     */
    public function load($path): EnhancedFile
    {
        $this->path = $path;

        PDFValidator::validate($this);

        return $this;
    }

    public function sign(array $certificateInfo = [])
    {
        // TODO: Implement sign() method.
        // get the file content
        // check if it hasn't been signed yet
        // sign the file
        // sign the header
        // create a signature with the signed file and the header
        // embed the signature
        // save the file
    }

    public function verify(): array
    {
        // TODO: Implement verify() method.
        // get the file content
        // get the signature
        return [];
    }

    /**
     * @throws Exception
     */
    public static function __callStatic($name, $arguments): mixed
    {
        if (method_exists(EnhancedPDF::class, $name)) {
            return call_user_func_array([EnhancedPDF::class, $name], $arguments);
        }
        throw new Exception("Method $name does not exist.");
    }

    public function path(): string
    {
        return $this->path;
    }

}