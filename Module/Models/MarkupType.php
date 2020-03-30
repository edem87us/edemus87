<?php

namespace App\Services\Markup\Module\Models;

/**
 * Class MarkupType
 * @package App\Services\Markup\Module
 */
class MarkupType
{
    /**
     * @var array
     */
    private $onex = [];

    /**
     * @var array
     */
    private $agency = [];

    /**
     * @var float
     */
    private $client = 0.00;

    /**
     * @var array
     */
    private $filter = [];

    /**
     * @param int $supplierId
     * @return float
     */
    public function getOnex(int $supplierId): float
    {
        return $this->onex[$supplierId];
    }

    /**
     * @param float $markup
     * @param int   $supplierId
     */
    public function setOnex(float $markup, int $supplierId): void
    {
        $this->onex[$supplierId] = $markup;
    }

    /**
     * @param int $supplierId
     * @return float
     */
    public function getAgency(int $supplierId): float
    {
        return $this->agency[$supplierId];
    }

    /**
     * @param float $markup
     * @param int   $supplierId
     */
    public function setAgency(float $markup, int $supplierId): void
    {
        $this->agency[$supplierId] = $markup;
    }

    /**
     * @return float
     */
    public function getClient(): float
    {
        return $this->client;
    }

    /**
     * @param float $client
     */
    public function setClient(float $client): void
    {
        $this->client = $client;
    }

    /**
     * @param int $supplierId
     * @return float
     */
    public function getFilter(int $supplierId): float
    {
        return $this->filter[$supplierId];
    }

    /**
     * @param float $markup
     * @param int   $supplierId
     */
    public function setFilter(float $markup, int $supplierId): void
    {
        $this->filter[$supplierId] = $markup;
    }
}