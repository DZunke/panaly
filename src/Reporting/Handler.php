<?php

declare(strict_types=1);

namespace Panaly\Reporting;

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
        $this->runtimeConfiguration->getLogger()->debug('Handling reporting engines.');

        foreach ($this->configurationFile->reporting as $executeReport) {
            $this->runtimeConfiguration->getLogger()->debug(
                'Handling reporting "{report}".',
                ['report' => $executeReport->identifier],
            );

            $reportHandler = $this->runtimeConfiguration->getReporting($executeReport->identifier);
            $reportHandler->report($result, $executeReport->options);
        }
    }
}
