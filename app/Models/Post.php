<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    

    protected $table = 'posts';
    protected $fillable = ["title", 'slug', "description", "image", "posted_by", "creator_id"];

    function creator()
    {
        return $this->belongsTo(Creator::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }


    public function getHumanReadableDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M Y, h:i A');
    }
}
