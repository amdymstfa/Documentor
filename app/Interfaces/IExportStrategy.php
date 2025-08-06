<?php

namespace App\Interfaces ;

interface IExportStrategy {
    public function export(IDocument $document): string;
    public function getFileExtension(): string;
    public function getMimeType(): string;
}