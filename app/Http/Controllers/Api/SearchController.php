<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\API\ApiHelper;
use App\Repos\Repository;
use App\Video;

class SearchController extends Controller
{
     // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        // $error = ['error' => 'No results found, please try with different keywords.'];

        // // Making sure the user entered a keyword.
       

        // // Return the error message if no keywords existed
        // return $error;
    use ApiHelper;
    protected $model;

    /**
     * VideoController constructor.
     *
     * @param Video $video
     */
        public function __construct(Video $video)
        {
            $this->model = new Repository( $video );

            // Protect all except reading
            $this->middleware('auth:api', ['except' => ['index', 'show'] ]);
        }


        public function search(Request $request)
        {
            // $video = Video::search($request->get('q'))->get();
            // \Log::info($video);
            // return json_decode($video);
            
            $error = ['error' => 'No results found, please try with different keywords.'];
             if($request->has('q')) {

            // Using the Laravel Scout syntax to search the products table.
            $video = Video::search($request->get('q'))->get();
            // $video = Video::where('title',$request->get('q'))->get();

            // If there are results return them, if none, return the error message.
            return $video->count() ? $video : $error;

            }
        }

        
}
