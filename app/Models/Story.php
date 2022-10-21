<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Story extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'story';
    }

    // public function getThumbnailAttribute()
    // {
    //     return \Config::get('app.url').$this->attributes['thumbnail'];
    // }

    public function chapter(){
        return $this->hasMany(Chapter::class, 'story_id','id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'story_category', 'story_id', 'category_id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class, 'story_tags', 'story_id', 'tags_id');
    }

    static function getStorys($params) {
        $key_cache = md5(serialize($params));
        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        extract($params);

        if (isset($category_id)) {
            $data_id = Category::listItemChild($category_id,'id');
            $data = new self;
            $id = [$category_id];
            foreach($data_id as $T){
                $id[] = $T->id;
            }
            $data = $data->select('story.*', 'story_category.story_id', 'story_category.category_id','story_category.is_primary')->Join('story_category', 'story_category.story_id', '=', 'story.id');
            if(!empty($id)){
                $data = $data->whereIn('story_category.category_id', $id);
            }else{
                $data = $data->where('story_category.category_id', $category_id);
            }
            if (!empty($only_primary_category)) {
                $data = $data->where('story_category.is_primary', 1);
            }
        }

        if (isset($tag_id)) {
            $data = $data->select('story.*', 'story_tags.story_id', 'story_tags.tag_id')->Join('story_tags', 'story_tags.story_id', '=', 'story.id');
            $data = $data->where('story_tags.tag_id', $tag_id);
        }

        if (isset($info_category)) {
            $data = $data->with(['categories' => function($q){
                return $q->where('is_primary', 1);
            }]);
        }

        if (isset($get_category)) {
            $data = $data->with('categories');
        }
        if(isset($exclude)){
            $data = $data->whereNotIn('story.id', $exclude);
        }
        $offset = $offset ?? 0;
        $limit = $limit ?? 10;

        $data = $data->orderBy('story.created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->groupBy('story.id')
            ->get();
        Cache::set($key_cache, $data, now()->addHours(12));
        return $data;
    }

    static function getCount($params) {
        $key_cache = md5(serialize($params).'count');
        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        $data = new self;
        extract($params);

        if (isset($category_id)) {
            $data_id = Category::listItemChild($category_id,'id');
            $id = [$category_id];
            foreach($data_id as $T){
                $id[] = $T->id;
            }
            $data = $data->join('story_category', 'story_category.story_id', '=', 'story.id');
            if(!empty($id)){
                $data = $data->whereIn('story_category.category_id', $id);
            }else{
                $data = $data->where('story_category.category_id', $category_id);
            }
            
            if (!empty($only_primary_category)) {
                $data = $data->where('story_category.is_primary', 1);
            }
        }

        if (isset($tag_id)) {
            $data = $data->select('story.*', 'story_tags.story_id', 'story_tags.tag_id')->Join('story_tags', 'story_tags.story_id', '=', 'story.id');
            $data = $data->where('story_tags.tag_id', $tag_id);
        }
        
        if(isset($exclude)){
            $data = $data->whereNotIn('story.id', $exclude);
        }
        $count_data = $data->groupBy('story.id')->get()->count();
        Cache::set($key_cache, $count_data, now()->addHours(12));

        return $count_data;
    }
}
