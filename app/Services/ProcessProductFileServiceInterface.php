<?php

namespace App\Services;
/**
 * TODO: Maybe use Facade instead of service and DI but that is not important :)
 */
interface ProcessProductFileServiceInterface
{
    /**
     * @param string $fileName
     * @return array<string, float|array<string, int|float>
     */
    public function processFile(string $fileName): array;
}
