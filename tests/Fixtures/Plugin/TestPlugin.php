<?php

declare(strict_types=1);

namespace Panaly\Test\Fixtures\Plugin;

use InvalidArgumentException;
use Panaly\Plugin\BasePlugin;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Plugin\Plugin\Reporting;
use Panaly\Plugin\Plugin\Storage;
use Panaly\Result\Metric\IntegerValue;
use Panaly\Result\Metric\Value;
use Panaly\Result\Result;
use Symfony\Component\VarDumper\VarDumper;

use function file_put_contents;
use function json_encode;

use const JSON_PRETTY_PRINT;
use const JSON_THROW_ON_ERROR;

class TestPlugin extends BasePlugin
{
    /** @inheritDoc */
    public function getAvailableMetrics(array $options): array
    {
        return [
            new class implements Metric {
                public function getIdentifier(): string
                {
                    return 'a_static_integer';
                }

                public function getDefaultTitle(): string
                {
                    return 'I am a default title';
                }

                public function calculate(array $options): Value
                {
                    return new IntegerValue(12);
                }
            },
        ];
    }

    /** @inheritDoc */
    public function getAvailableStorages(array $options): array
    {
        return [
            new class implements Storage {
                public function getIdentifier(): string
                {
                    return 'single_json';
                }

                public function store(Result $result, array $options): void
                {
                    $file = __DIR__ . '/../../../' . ($options['file'] ?? 'panaly-single-json-result.json');

                    if (
                        file_put_contents(
                            $file,
                            json_encode($result->toArray(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT),
                        ) === false
                    ) {
                        throw new InvalidArgumentException(
                            'The file "' . $file . '" configured in "file" option is not writable.',
                        );
                    }
                }
            },
        ];
    }

    /** @inheritDoc */
    public function getAvailableReporting(array $options): array
    {
        return [
            new class implements Reporting {
                public function getIdentifier(): string
                {
                    return 'symfony_dump';
                }

                public function report(Result $result, array $options): void
                {
                    VarDumper::dump($result);
                }
            },
        ];
    }
}
