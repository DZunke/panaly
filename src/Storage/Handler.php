<?php

declare(strict_types=1);

namespace Panaly\Storage;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Result\Result;

class Handler
{
    public function __construct(
        private readonly ConfigurationFile $configurationFile,
        private readonly RuntimeConfiguration $runtimeConfiguration,
    ) {
    }

    public function handle(Result $result): void
    {
        foreach ($this->configurationFile->storage as $executeStorage) {
            $storageHandler = $this->runtimeConfiguration->getStorage($executeStorage->identifier);
            $storageHandler->store($result, $executeStorage->options);
        }
    }
}
