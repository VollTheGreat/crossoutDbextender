<?php

namespace App\CrossoutDB\Entity;

class BaseRecipeDetails
{
    protected $largeMetalId = 57;
    protected $largeMetalCountIndex = 1000;
    protected $metalId = 53;
    protected $metalCountIndex = 100;

    protected $largeCooperId = 43;
    protected $largeCooperCountIndex = 100;
    protected $cooperId = 76;
    protected $cooperCountIndex = 10;

    protected $largeWiresId = 85;
    protected $largeWiresCountIndex = 100;
    protected $wiresId = 216;
    protected $wiresCountIndex = 10;

    protected $resources;
    protected $workbenchPrice;
    protected $metalResourceRequest;
    protected $cooperResourceRequest;
    protected $wiresResourceRequest;

    /**
     * @param array $resources
     */
    public function __construct(array $resources)
    {
        $this->resources = $resources;
    }

    /**
     * @return float
    */
    public function getPrice(): float
    {
        return $this->metalResourceRequest / $this->metalCountIndex * $this->resources[$this->metalId]['formatBuyPrice']
            + $this->cooperResourceRequest / $this->largeCooperCountIndex * $this->resources[$this->largeCooperId]['formatBuyPrice']
            + $this->wiresResourceRequest / $this->wiresCountIndex * $this->resources[$this->wiresId]['formatBuyPrice'];
    }

    /**
     * @return float
     */
    public function getWorkbenchPrice(): float
    {
        return $this->workbenchPrice;
    }

}