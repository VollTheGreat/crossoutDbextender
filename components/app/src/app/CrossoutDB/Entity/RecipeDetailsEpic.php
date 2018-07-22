<?php

namespace App\CrossoutDB\Entity;


class RecipeDetailsEpic extends BaseRecipeDetails implements RecipeInterface
{
    protected  $workbenchPrice = 18;
    protected  $metalResourceRequest = 250;
    protected  $cooperResourceRequest = 150;
    protected  $wiresResourceRequest = 750;
}