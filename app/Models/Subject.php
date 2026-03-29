<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model
{
    /** @use HasFactory<SubjectFactory> */
    use HasFactory;

    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'slug', 'user_id'];

    /**
     * Scope to filter subjects by user.
     *
     * @param  mixed  $query
     * @param  mixed  $userId
     * @return Builder<Subject>
     */
    public function scopeForUser($query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for currently authenticated user.
     *
     * @param  mixed  $query
     * @return Builder<Subject>
     */
    public function scopeForCurrentUser($query): Builder
    {
        return $query->where('user_id', Auth::id());
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
