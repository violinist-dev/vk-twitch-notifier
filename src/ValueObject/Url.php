<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\InvalidValueObjectException;

class Url
{
    /**
     * @var string
     */
    private $fullUrl;

    /**
     * @var string|null
     */
    private $hash;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string|null
     */
    private $pass;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var string|null
     */
    private $port;

    /**
     * @var string|null
     */
    private $query;

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string|null
     */
    private $user;

    public function __construct(string $fullUrl)
    {
        $this->fullUrl = $fullUrl;

        $parsedUrl = parse_url($fullUrl);

        $this->fullUrl = $fullUrl;
        $this->scheme = $parsedUrl['scheme'];
        $this->host = $parsedUrl['host'];
        $this->port = $parsedUrl['port'] ?? null;
        $this->user = $parsedUrl['user'] ?? null;
        $this->pass = $parsedUrl['pass'] ?? null;
        $this->path = $parsedUrl['path'] ?? null;
        $this->query = $parsedUrl['query'] ?? null;
        $this->hash = $parsedUrl['fragment'] ?? null;

        $this->validate();
    }

    public function getFullUrl(): string
    {
        return $this->fullUrl;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getSchemeRelativeUrl(): string
    {
        return str_replace($this->getScheme(), '', $this->fullUrl);
    }

    public function getUrlWithoutScheme(): string
    {
        return str_replace($this->getScheme() . '://', '', $this->fullUrl);
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    private function validate(): void
    {
        if (filter_var($this->fullUrl, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED) === false) {
            throw new InvalidValueObjectException(sprintf(
                'Invalid URL passed: %s',
                $this->fullUrl
            ));
        }
    }
}
