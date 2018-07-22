<?php
namespace App\CrossoutDB\Entity;

interface RecipeInterface
{
    /**
     * @return float
     */
    public function getPrice():float;

    /**
     * @return float
     */
    public function getWorkbenchPrice(): float;
}