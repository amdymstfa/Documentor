<?php

namespace App\Interfaces ;


interface IGenerateurExport
{
    public function export(IDocument $document, string $format): string;
    public function getSupportedFormats(): array;
    public function setTemplate(string $template): void;
}