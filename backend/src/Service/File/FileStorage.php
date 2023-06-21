<?php

declare(strict_types=1);

namespace App\Service\File;

use App\Entity\File;
use App\Exception\FileException;
use Aws\S3\S3Client;
use GuzzleHttp\Psr7\Stream;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class FileStorage
{
    private ?S3Client $client = null;

    private string $awsRegion;
    private string $awsEndpoint;
    private string $awsKey;
    private string $awsSecret;
    private string $awsBucket;

    public function __construct(
        string $awsRegion,
        string $awsEndpoint,
        string $awsKey,
        string $awsSecret,
        string $awsBucket
    ) {
        $this->awsRegion = $awsRegion;
        $this->awsEndpoint = $awsEndpoint;
        $this->awsKey = $awsKey;
        $this->awsSecret = $awsSecret;
        $this->awsBucket = $awsBucket;
    }

    public function save(File $file, UploadedFile $uploadedFile): void
    {
        try {
            $this->getClient()->putObject([
                'Bucket' => $this->awsBucket,
                'Key' => (string)$file->getId(),
                'Body' => fopen($uploadedFile->getPathname(), 'r'),
            ]);
        } catch (Throwable $e) {
            throw FileException::save($e->getMessage());
        }
    }

    public function getFileContent(File $file): Stream
    {
        try {
            /** @var array{Body: Stream} */
            $result = $this->getClient()->getObject([
                'Bucket' => $this->awsBucket,
                'Key' => (string)$file->getId(),
            ]);

            return $result['Body'];
        } catch (Throwable $e) {
            throw FileException::download($e->getMessage());
        }
    }

    private function getClient(): S3Client
    {
        if ($this->client === null) {
            $this->client = new S3Client([
                'version' => 'latest',
                'region' => $this->awsRegion,
                'endpoint' => $this->awsEndpoint,
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key' => $this->awsKey,
                    'secret' => $this->awsSecret,
                ],
            ]);

            $this->initBucket();
        }

        return $this->client;
    }

    private function initBucket(): void
    {
        /** @var array $buckets */
        $buckets = $this->getClient()->listBuckets();
        /** @var array{Name: string} $bucket */
        foreach ($buckets['Buckets'] as $bucket) {
            if ($bucket['Name'] === $this->awsBucket) {
                return;
            }
        }

        try {
            $this->getClient()->createBucket([
                'Bucket' => $this->awsBucket,
            ]);
        } catch (Throwable $e) {
            throw FileException::internal($e->getMessage());
        }
    }
}
