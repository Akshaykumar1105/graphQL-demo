<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Plank\Mediable\Mediable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, Sluggable, SoftDeletes,  Mediable, FilterTrait;

    protected $fillable = [
        'user_id',
        'category_id',
        'slug',
        'title',
        'summary',
        'description',
        'is_published',
    ];

    public $relationships = ['user', 'category'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function relationships()
    {
        return $this->relationships;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('summary', 'like', "%$search%");
        });
    }

    public function scopeCategoryId($query, $categoryId)
    {
        return $query->whereCategoryId($categoryId);
    }

    public function scopeIsPublished($query, $isPublished)
    {
        return $query->whereIsPublished($isPublished);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
