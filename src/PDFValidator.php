<?php

class PDFValidator
{
    /**
     * @throws Exception
     */
    public static function validate(string $path): bool
    {
        if (!file_exists($path)) {
            throw new Exception('File not found.');
        }
        if (!is_file($path)) {
            throw new Exception('Not a file.');
        }
        if (!is_readable($path)) {
            throw new Exception('File not readable.');
        }
        if (!is_writable($path)) {
            throw new Exception('File not writable.');
        }
        if (mime_content_type($path) !== 'application/pdf' || pathinfo($path, PATHINFO_EXTENSION) !== 'pdf') {
            throw new Exception('Not a PDF file.');
        }
        if (filesize($path) > 2 * 1024 * 1024) {
            throw new Exception('File size exceeds 2MB.');
        }
        return true;
    }
}