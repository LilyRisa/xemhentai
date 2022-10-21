<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{   
    public function index()
    {

        $key = md5('home_new');
        if(Cache::has($key)){
            $data['new'] = Cache::get($key);
        }else{
            $data['new'] = Story::with(['categories', 'chapter'])->whereHas('chapter', function($q){
                return $q->orderBy('id','DESC');
            })->orderBy('created_at', 'DESC')->limit(12)->get();
            Cache::set($key, $data['new'], now()->addHours(12));
        }

        //truyện lượt xem cao nhất
        $key = md5('home_story_view_highest');
        if(Cache::has($key)){
            $data['view_hight'] = Cache::get($key);
        }else{
            $data['view_hight'] = Story::with(['categories', 'chapter'])->orderBy('view_count', 'DESC')->limit(8)->get()->map(function ($query) {
                $query->setRelation('chapter', $query->chapter->take(1));
                return $query;
            });
            Cache::set($key, $data['view_hight'], now()->addHours(24));
        }

        
        // menu
        $key = md5('home_menu_home');
        if(Cache::has($key)){
            $data['menu_home'] = Cache::get($key);
        }else{
            $data['menu_home'] = Menu::where('id', 3)->first();
            $data['menu_home'] = !empty($data['menu_home']) ? json_decode($data['menu_home']->data) : null;
            Cache::set($key, $data['menu_home'], now()->addHours(24));
        }
        

        $data['breadCrumb'][0]['item'] = url('/');
        $data['schema'] = getSchemaLogo().getLocalBusiness();
        $data['seo_data'] = initSeoData(null,'home');
        // dd($data);
        return view('web.home.index', $data);
    }
}
