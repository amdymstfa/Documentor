<?php

namespace App\Interfaces;

interface IVersionable
{
    public function createVersion(string $comment) : int;
    public function getVersions() : array;
    public function getVersion(int $versionNumber) : ?array;
    public function restoreVersion(int $versionNumber) : bool;
    public function compareVersion(int $version1, int $version2) : bool;
}
