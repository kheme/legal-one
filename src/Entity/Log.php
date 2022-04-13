<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LogRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\LogController;


/**
 * @ORM\Entity
 * @ORM\Table(name="logs")
 * @ApiResource(
 *  itemOperations={
 *    "filter" = {
 *       "method" = "GET",
 *       "path" = "/count",
 *       "controller" = LogController::class,
 *       "read"=false,
 *       "openapi_context" = {
 *         "parameters" = {
 *           {
 *              "name"        = "serviceNames",
 *              "in"          = "path",
 *              "description" = "Service name of interest",
 *              "type"        = "string",
 *              "required"    = true,
 *              "example"     = "USER-SERVICE",
 *           },
 *         },
 *       },
 *    }
 *  }
 * )
 */
#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 128)]
    private $service;

    #[ORM\Column(type: 'string', length: 16)]
    private $method;

    #[ORM\Column(type: 'string', length: 128)]
    private $url;

    #[ORM\Column(type: 'string', length: 16)]
    private $http;

    #[ORM\Column(type: 'smallint', length: 3)]
    private $status;

    #[ORM\Column(type: 'string', length: 5)]
    private $timezone;

    #[ORM\Column(type: 'datetimetz')]
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getHttp(): ?string
    {
        return $this->http;
    }

    public function setHttp(string $http): self
    {
        $this->http = $http;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
