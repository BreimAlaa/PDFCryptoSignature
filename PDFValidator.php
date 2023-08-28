<?php

class PDFValidator
{
    /**
     * @throws Exception
     */
    public static function validate(EnhancedPDF $PDF): bool
    {
        if (!file_exists($PDF->path())) {
            throw new Exception('File not found.');
        }
        if (!is_file($PDF->path())) {
            throw new Exception('Not a file.');
        }
        if (!is_readable($PDF->path())) {
            throw new Exception('File not readable.');
        }
        if (!is_writable($PDF->path())) {
            throw new Exception('File not writable.');
        }
        if (mime_content_type($PDF->path()) !== 'application/pdf' || pathinfo($PDF->path(), PATHINFO_EXTENSION) !== 'pdf') {
            throw new Exception('Not a PDF file.');
        }
        if (filesize($PDF->path()) > 2 * 1024 * 1024) {
            throw new Exception('File size exceeds 2MB.');
        }
        return true;
    }
}