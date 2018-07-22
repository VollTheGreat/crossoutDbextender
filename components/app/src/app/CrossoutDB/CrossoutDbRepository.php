<?php

namespace App\CrossoutDB;

use App\Models\Recipe;
use Carbon\Carbon;
use Throwable;

class CrossoutDbRepository
{
    const HTTPS_CROSSOUTDB_COM = 'https://crossoutdb.com';
    const API_RECIPE = '/api/v1/recipe/';
    const API_ITEMS = '/api/v1/items/';
    const ITEM_UPDATE_TIMEOUT = 300;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getDbData()
    {
        return collect($this->getJson(self::API_ITEMS));
    }

    /**
     * @param $uri
     * @return mixed
     */
    public function getJson(string $uri)
    {
        return json_decode(file_get_contents(self::HTTPS_CROSSOUTDB_COM . (string)$uri));
    }

    /**
     * @param int $recipeId
     * @param Carbon $time
     * @return mixed
     */
    public function getRecipeById(int $recipeId, Carbon $time)
    {
        $recipe = $this->fetchLocalRecipe($recipeId);
        $isLocalRecipe = (bool)$recipe;
        if (!$isLocalRecipe) {
            $recipe = Recipe::updateOrCreate([
                'recipe_id' => $recipeId,
            ], [
                'recipe_id' => $recipeId,
                'data' => json_encode($this->getApiRecipeData($recipeId))
            ]);
        } else {
            $isInnerTimeReason = $recipe->updated_at->diffInSeconds($time) > self::ITEM_UPDATE_TIMEOUT;
            if ($isInnerTimeReason) {
                $apiRecipeData = $this->getApiRecipeData($recipeId);
                if ($apiRecipeData) {
                    $recipe = Recipe::updateOrCreate([
                        'recipe_id' => $recipeId,
                    ], [
                        'recipe_id' => $recipeId,
                        'data' => json_encode($apiRecipeData)
                    ]);
                }
            }
        }

        return json_decode($recipe->data);
    }

    /**
     * @param $recipeId
     * @return mixed
     */
    public function getApiRecipeData($recipeId)
    {
        try {
            return $this->getJson(self::API_RECIPE . $recipeId);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    /**
     * @param $recipeId
     * @return Recipe|\Illuminate\Database\Eloquent\Model|null
     */
    public function fetchLocalRecipe($recipeId)
    {
        return Recipe::where('recipe_id', '=', $recipeId)->first();
    }
}