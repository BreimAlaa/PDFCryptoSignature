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
            $this->loadFile($path);
        }
    }

    /**
     * @throws Exception
     */
    public function loadFile($path): EnhancedFile
    {
        $this->path = $path;

        PDFValidator::validate($this);

        return $this;
    }
    /**
     * @throws Exception
     */
    public static function load($path): EnhancedFile
    {
        $enhancedPDF = new self($path);
        PDFValidator::validate($enhancedPDF);

        return $enhancedPDF;
    }

    public function sign(array $signerInfo = []): void
    {
        // TODO: Implement sign() method.
        // get the file content
        // check if it hasn't been signed yet
        // sign the file
        // sign the header
        // create a signature with the signed file and the header
        // embed the signature
        // save the file

        $content = file_get_contents($this->path);
        $base64_file = base64_encode($content);
        $hash = hash('sha256', $base64_file);

        $certificateInfo['version'] = 1;
        $certificateInfo['date'] = date('Y-m-d H:i:s');

        $details = json_encode($certificateInfo);

        $base64_details = base64_encode($details);

        $comment = '#@#' . $hash . '#@#' . $base64_details;

        $modifiedPDFContent = $content . '\n' . '% ' . $comment;

        file_put_contents($this->path, $modifiedPDFContent);
    }

    public function verify(): array
    {
        try {
            $content = file_get_contents($this->path);

            $file = explode('\\n% #@#', $content);
            $base64_file = base64_encode($file[0]);

            $hash = hash('sha256', $base64_file);

            $provided_hash = explode('#@#', $file[1])[0];
            $provided_details = explode('#@#', $file[1])[1];
            $details = json_decode(base64_decode($provided_details), true);

            $details['verified'] = $hash == $provided_hash ? 'Yes' : 'No';

            $to_camel_case = function ($string) {
                $string = str_replace('_', ' ', $string);
                return ucwords($string);
            };
            $details = array_combine(
                array_map($to_camel_case, array_keys($details)),
                $details
            );
        } catch (Exception $e) {
            $details = ['verified' => 'No'];
        }
        return $details;
    }

    public function path(): string
    {
        return $this->path;
    }

}