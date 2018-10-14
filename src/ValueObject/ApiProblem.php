<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enum\ApiProblemType;

class ApiProblem
{
    /**
     * @var string
     */
    private $detail;

    /**
     * @var string|null
     */
    private $instance;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $title;

    /**
     * @var ApiProblemType
     */
    private $type;

    public function __construct(
        int $status,
        ApiProblemType $type,
        string $title,
        string $detail,
        ?string $instance = null
    ) {
        $this->status = $status;
        $this->type = $type;
        $this->title = $title;
        $this->detail = $detail;
        $this->instance = $instance;
    }

    public function getDetail(): string
    {
        return $this->detail;
    }

    public function getInstance(): ?string
    {
        return $this->instance;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getType(): ApiProblemType
    {
        return $this->type;
    }
}
