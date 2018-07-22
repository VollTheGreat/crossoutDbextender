<?php
namespace App\CrossoutDB;

use App\CrossoutDB\Entity\RecipeDetailsEpic;
use App\CrossoutDB\Entity\RecipeDetailsRare;
use App\CrossoutDB\Entity\RecipeInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CrossoutDbManager
{
    const COMMISSION_MULTIPLIER = 0.9;
    const CRAFT_ITEMS_TYPES = [
        'Weapons',
        'Cabins',
        'Hardware',
        'Movement'];
    const CRAFT_ITEMS_TYPES_KEYS = [
        'Weapons' => 1,
        'Cabins' => 1,
        'Hardware' => 1,
        'Movement' => 1
    ];

    const CRAFT_RESOURCES_IDS = [
        57,53,43,76,85,216,785,786
    ];

    /**
     * @var CrossoutDbRepository
     */
    private $crossoutDbRepository;

    /**
     * CrossoutDbManager constructor.
     * @param CrossoutDbRepository $crossoutDbRepository
     */
    public function __construct(CrossoutDbRepository $crossoutDbRepository)
    {
        $this->crossoutDbRepository = $crossoutDbRepository;
    }

    /**
     * @param string $rarityLevel
     * @param string $ingredientType
     * @return array
     */
    public function getFormattedData(string $rarityLevel, string $ingredientType): array
    {
        $apiItems = $this->crossoutDbRepository->getDbData();
        $epics = $this->fetchComponentItems($apiItems, $rarityLevel, $ingredientType);
        switch ($rarityLevel){
            case 'Rare':
                $recipe = new RecipeDetailsRare($this->fetchResources($apiItems));
                break;
            case 'Epic':
                $recipe = new RecipeDetailsEpic($this->fetchResources($apiItems));
                break;
            default:
                $recipe = new RecipeDetailsEpic($this->fetchResources($apiItems));
                break;
        }

        return [
            'crafts' => $this->formatProfitableStatistic(collect($epics), $recipe),
            'bestProfitableRates' => $this->formatItemsStatistic(collect($epics), $recipe),
            'craftEpicRentalPrice' => formatFloat($recipe->getPrice()),
            'craftWorkBenchPrice' => formatFloat($recipe->getWorkbenchPrice()),
            'epicsData' => collect($epics),
        ];
    }

    /**
     * @param $apiItems
     * @param $rarityLevel
     * @param $ingredientType
     * @return array
     */
    public function fetchComponentItems($apiItems, $rarityLevel, $ingredientType): array
    {
        $items = $this->fetchItems($apiItems, $rarityLevel);

        foreach ($items as &$item) {
         //   $item['componentItem'] = $this->getIngredients($item['id'], $ingredientType);
       //     $item['totalPrice'] = $item['componentItem']['totalBuyPrice'];

            $item['totalPrice'] = $this->getIngredients($item['id'], $ingredientType);
        }
        return $items;
    }

    /**
     * @param Collection $apiItems
     * @param string $rarityLevel
     * @return array
     */
    public function fetchItems(Collection $apiItems, string $rarityLevel): array
    {
        $items = [];
        $data = $apiItems
            ->whereIn('rarityName', [$rarityLevel])
            ->whereIn('factionNumber', [1, 2, 3, 4, 5, 6, 7])
            // ->whereIn('faction', ['Engineers', 'Lunatics', 'Nomand', 'Scavanger', 'Steppenwolfs', "Dawn's Children", 'Firestarters'])
            //->whereNotIn('categoryName', ['Decor', 'Dyes'])
            ->whereIn('categoryName', self::CRAFT_ITEMS_TYPES);
        foreach ($data as $item) {
            $items[$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'formatBuyPrice' => formatFloat($item->formatBuyPrice),
                'formatSellPrice' => formatFloat($item->formatSellPrice),
                'categoryName' => $item->categoryName,
                'typeName' => $item->typeName,
                'faction' => $item->faction,
                'lastUpdateTime' => $item->lastUpdateTime,
                'rarityName' => $item->rarityName,
            ];
        }

        return $items;
    }

    /**
     * @param $id
     * @param $ingredientRarity
     * @return mixed
     */
    public function getIngredients($id, $ingredientRarity)
    {
        $time = Carbon::now();
        $recipe = $this->crossoutDbRepository->getRecipeById((int) $id, $time)->recipe;
        $itemRecipeIngredients = $recipe->ingredients;
        $ingredients = [];

        if (!isset($ingredients['total'])) {
            $ingredients['totalBuyPrice'] = 0;
        }

        foreach ($itemRecipeIngredients as $ingredient) {
            if (
                $ingredient->item->rarityName === $ingredientRarity
                && array_has(self::CRAFT_ITEMS_TYPES_KEYS, $ingredient->item->categoryName)
            ) {
                $ingredients[$ingredient->id] = [
                    'name' => $ingredient->item->name,
                    'formatBuyPrice' => $ingredient->item->formatBuyPrice,
                ];
                $ingredients['totalBuyPrice'] += $ingredient->item->formatBuyPrice * $ingredient->number;
            }
        }

        return formatFloat($ingredients['totalBuyPrice']);
    }

    /**
     * @param Collection $apiItems
     * @return array
     */
    public function fetchResources(Collection $apiItems)
    {
        $apiResources = $apiItems->whereIn('id', self::CRAFT_RESOURCES_IDS);
        $resources = [];
        foreach ($apiResources as $item) {
            $resources[$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'formatBuyPrice' => formatFloat($item->formatBuyPrice),
                'formatSellPrice' => formatFloat($item->formatSellPrice),
                'categoryName' => $item->categoryName,
                'typeName' => $item->typeName,
                'faction' => $item->faction,
                'lastUpdateTime' => $item->lastUpdateTime,
                'rarityName' => $item->rarityName,
            ];
        }

        return $resources;
    }

    /**
     * @param Collection $items
     * @param RecipeInterface $recipe
     * @return mixed
     */
    public function formatProfitableStatistic(Collection $items,RecipeInterface $recipe)
    {
        return $items->map(function ($item) use ($recipe) {
            return [
                $item['name'] => formatFloat(self::COMMISSION_MULTIPLIER * $item['formatSellPrice'] - ($item['totalPrice'] + $recipe->getPrice() + $recipe->getWorkbenchPrice()))];
        })->collapse()->sort();
    }

    /**
     * @param Collection $items
     * @param RecipeInterface $recipe
     * @return mixed
     */
    public function formatItemsStatistic(Collection $items,RecipeInterface $recipe)
    {
        return $items->map(function ($item) use ($recipe) {
            return [
                $item['name'] => formatFloat(self::COMMISSION_MULTIPLIER * $item['formatSellPrice'] - ($item['totalPrice'] + $recipe->getPrice()))];
        })->collapse()->sort();
    }
}
