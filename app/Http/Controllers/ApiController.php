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
use Illuminate\Pagination\Paginator;
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
    
    public function meals(Request $request){

        $lang = $request->input('lang', FALSE);
        $tags = $request->input('tags', FALSE);
        $diff_time = $request->input('diff_time', FALSE);
        $per_page = $request->input('per_page', FALSE);
        $page = $request->input('page', FALSE);
        $withs = $request->input('with', FALSE);
        
        $tags = explode(',', $tags);
        $withs = explode(',', $withs);
        
        $filterLang = ($lang && $lang != NULL && $lang != '') ? $lang : false;
        $filterTags = ($tags && $tags != NULL && $tags != '') ? $tags : false;
        $filterDiffTime = ($diff_time && $diff_time != NULL && $diff_time != '') ? $diff_time : 'created';
        $filterPerPage = ($per_page && $per_page != NULL && $per_page != '') ? $per_page : false;
        $filterPage = ($page && $page != NULL && $page != '') ? $page : false;
        
        $filterIngredients = $filterCategory = $filterTagsW = null;
        foreach($withs as $with){
            if($with == 'ingredients')  $filterIngredients = ($with && $with != NULL && $with != '') ? $with : false;
            if($with == 'category')  $filterCategory = ($with && $with != NULL && $with != '') ? $with : false;
            if($with == 'tags')  $filterTagsW = ($with && $with != NULL && $with != '') ? $with : false;
        }

        Paginator::currentPageResolver(function () use ($filterPage) {
            return $filterPage;
        });

        $result = Meals::select('meals.id', 'mt.title', 'mt.description', 'meals.slug')
                        ->when($filterIngredients, function ($q) use ($filterLang) {
                            return $q->with(['ingredients' => function ($q) use ($filterLang) {
                                    return $q->leftJoin('ingredient_translations as it', 'ingredients.slug', 'it.slug')
                                            ->select('it.id', 'it.title', 'ingredients.slug')
                                            ->where('it.locale', $filterLang);
                                }
                            ]);
                        })
                        ->when($filterTagsW, function ($q) use ($filterLang) {
                            return $q->with(['tags' => function ($q) use ($filterLang) {
                                    return $q->leftJoin('tag_translations as tt', 'tags.slug', 'tt.slug')
                                            ->select('tt.id', 'tt.title', 'tags.slug')
                                            ->where('tt.locale', $filterLang);
                                }
                            ]);
                        })
                        ->when($filterCategory, function ($q) use ($filterLang) {
                            return $q->with(['categories' => function ($q) use ($filterLang) {
                                    return $q->leftJoin('category_translations as ct', 'categories.slug', 'ct.slug')
                                            ->select('ct.id', 'ct.title', 'categories.slug')
                                            ->where('ct.locale', $filterLang);
                                }
                            ]);
                        })
                        ->where('mt.locale', $filterLang)
                        ->when($filterTags, function ($q) use ($filterTags) {
                            $q->whereIn('tags.id', $filterTags);
                        })
                        ->leftJoin('meal_translations as mt', 'meals.slug', 'mt.slug')
                        ->leftJoin('meal_tags as mta', 'meals.slug', 'mta.meal_slug')
                        ->leftJoin('tags', 'mta.tag_slug', 'tags.slug')
                        ->paginate($filterPerPage);

        if($result) return response()->json([$result], 200);
        else return response()->json(['status' => 'error'], 500);
    }

    
}
    