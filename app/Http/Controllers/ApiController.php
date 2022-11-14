<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Ingredients;
use App\Models\Meals;
use App\Models\MealTranslation;
use App\Models\MealIngredient;
use App\Models\Tags;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ApiRequest;
use App\Helpers\ApiHelper;
use App\Http\Resources\DataResource;
use DB;


class ApiController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index()
    {
        return response()->json([
            'name' => 'Test API.',
            'status' => 'success',
            'code' => 200,
            'version' => '1.0'
        ], 200);
    }
    
    public function meals(ApiRequest $request){

        $lang = $request->input('lang', FALSE);
        $tags = $request->input('tags', FALSE);
        $category = $request->input('category', FALSE);
        $diff_time = $request->input('diff_time', FALSE);
        $per_page = $request->input('per_page', FALSE);
        $page = $request->input('page', FALSE);
        $withs = $request->input('with', FALSE);
        
        $tags_array = ApiHelper::get_array($tags);
        $categories_array = ApiHelper::get_array($category);
        $withs = ApiHelper::get_array($withs); 
        
        $withIngredients = $withCategory = $withTags = null;
        foreach($withs as $with){
            if($with == 'ingredients')
                {
                    $withIngredients = ($with && $with != NULL && $with != '') ? $with : false;
                }
            if($with == 'category')
            {
                $withCategory = ($with && $with != NULL && $with != '') ? $with : false;
            }
            if($with == 'tags')
            {
                $withTags = ($with && $with != NULL && $with != '') ? $with : false;
            }
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $result = Meals::select('meals.id', 'mt.title', 'mt.description', 'meals.slug')
                        ->when($tags, function ($query) use ($tags_array) {
                            return $query->whereIn('tags.id', $tags_array);
                        })
                        ->when($category, function ($query) use ($categories_array) {
                            return $query->whereIn('categories.id', $categories_array);
                        })
                        ->when($withIngredients, function ($q) use ($lang) {
                            return $q->with(['ingredients' => function ($q) use ($lang) {
                                    return $q->leftJoin('ingredient_translations as it', 'ingredients.slug', 'it.slug')
                                            ->select('it.id', 'it.title', 'ingredients.slug')
                                            ->where('it.locale', $lang);
                                }
                            ]);
                        })
                        ->when($withTags, function ($q) use ($lang, $tags, $tags_array) {
                            return $q->with(['tags' => function ($q) use ($lang, $tags, $tags_array) {
                                    return $q->leftJoin('tag_translations as tt', 'tags.slug', 'tt.slug')
                                            ->select('tt.id', 'tt.title', 'tags.slug')
                                            ->where('tt.locale', $lang)
                                            ->when($tags, function ($query) use ($tags_array) {
                                                return $query->whereIn('tags.id', $tags_array);
                                            });
                                }
                            ]);
                        })
                        ->when($withCategory, function ($q) use ($lang, $category, $categories_array) {
                            return $q->with(['categories' => function ($q) use ($lang, $category, $categories_array) {
                                    return $q->leftJoin('category_translations as ct', 'categories.slug', 'ct.slug')
                                            ->select('ct.id', 'ct.title', 'categories.slug')
                                            ->where('ct.locale', $lang)
                                            ->when($category, function ($query) use ($categories_array) {
                                                return $query->whereIn('categories.id', $categories_array);
                                            });
                                }
                            ]);
                        })
                        ->where('mt.locale', $lang)
                        ->leftJoin('meal_translations as mt', 'meals.slug', 'mt.slug')
                        ->leftJoin('meals_tags as mta', 'meals.slug', 'mta.meal_slug')
                        ->leftJoin('tags', 'mta.tag_slug', 'tags.slug')
                        ->leftJoin('meal_categories as mca', 'meals.slug', 'mca.meal_slug')
                        ->leftJoin('categories', 'mca.category_slug', 'categories.slug')
                        ->paginate($per_page);

        if($result){
            return DataResource::collection($result);
        }
        else return response()->json(['status' => 'error'], 500);
    }

    
}
    