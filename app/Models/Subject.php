<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'slug', 'user_id'];

    protected static function boot(): void
    {
        static::addGlobalScope('user', function ($query) {
            if (app()->runningInConsole() === false && auth()->guard()->check()) {
                $query->where('user_id', auth()->guard()->id());
            }
        });

        parent::boot();
    }

    /**
     * @return BelongsTo<User,Subject>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
