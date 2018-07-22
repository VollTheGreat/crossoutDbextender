<?php

namespace App\CrossoutDB\Entity;


class RecipeDetailsEpic extends BaseRecipeDetails implements RecipeInterface
{
    protected  $workbenchPrice = 18;
    protected  $metalResourceRequest = 250;
    protected  $cooperResourceRequest = 450;
    protected  $wiresResourceRequest = 500;
    protected  $plasticResourceRequest = 250;
}