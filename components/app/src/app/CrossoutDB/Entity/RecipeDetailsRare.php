<?php

namespace App\CrossoutDB\Entity;


class RecipeDetailsRare extends BaseRecipeDetails implements RecipeInterface
{
    protected  $workbenchPrice = 4.5;
    protected  $metalResourceRequest = 450;
    protected  $cooperResourceRequest = 50;
    protected  $wiresResourceRequest = 0;
    protected  $plasticResourceRequest = 0;
}