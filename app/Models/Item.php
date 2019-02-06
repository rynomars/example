<?php

namespace App\Models;

/**
 * App\Models\Item
 *
 * @property int $id
 * @property string $brand_id
 * @property string $part_number
 * @property int $status
 * @property int $error_level
 * @property int|null $category_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item archived()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereErrorLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item wherePartNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Item working()
 * @mixin \Eloquent
 */
class Item extends \Eloquent
{
    const STATUS_DRAFT = 0;
    const STATUS_REVIEW = 1;
    const STATUS_APPROVED = 2;
    const STATUS_ARCHIVED = 3;
    const STATUS_IMPORTED = 4;
    const STATUS_PUBLISHED = 8;

    /**
     * Get the associated Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the associated User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include "active" items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status',[
            Item::STATUS_IMPORTED,
            Item::STATUS_DRAFT,
            Item::STATUS_REVIEW,
            Item::STATUS_APPROVED
        ]);
    }

    /**
     * Scope a query to only include "working" items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWorking($query)
    {
        return $query->whereIn('status', self::getStatusWorkingKeys());
    }

    /**
     * Scope a query to only include "archived" items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->whereIn('status', self::getStatusArchivedKeys());
    }

    /**
     * Scope a query to only include "published" items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereIn('status', self::getStatusPublishedKeys());
    }
    /**
     * Get a array of all status keys that is within working status
     *
     * @return array
     */
    public static function getStatusWorkingKeys()
    {
        return [Item::STATUS_DRAFT, Item::STATUS_REVIEW, Item::STATUS_APPROVED];
    }

    /**
     * Get a array of all status keys that is within archive status
     *
     * @return array
     */
    public static function getStatusArchivedKeys()
    {
        return [Item::STATUS_ARCHIVED];
    }

    /**
     * Get a array of all status keys that is within published status
     *
     * @return array
     */
    public static function getStatusPublishedKeys()
    {
        return [Item::STATUS_PUBLISHED];
    }

    /**
     * Get a array of all status keys that is within imported status
     *
     * @return array
     */
    public static function getStatusImportedKeys()
    {
        return [Item::STATUS_IMPORTED];
    }

    /**
     * Get a array of all status keys
     *
     * @return array
     */
    public static function getStatusKeys()
    {
        return [
            Item::STATUS_DRAFT,
            Item::STATUS_REVIEW,
            Item::STATUS_APPROVED,
            Item::STATUS_ARCHIVED,
            Item::STATUS_IMPORTED,
            Item::STATUS_PUBLISHED,
        ];
    }

    /**
     * Get a array of exportable status keys
     *
     * @return array
     */
    public static function getExportableStatusKeys()
    {
        return [
            Item::STATUS_DRAFT,
            Item::STATUS_REVIEW,
            Item::STATUS_APPROVED,
            Item::STATUS_PUBLISHED,
        ];
    }

    /**
     * Get a array of creatable status keys
     *
     * @return array
     */
    public static function getCreatableStatusKeys()
    {
        return [
            Item::STATUS_IMPORTED,
            Item::STATUS_DRAFT,
        ];
    }

    /**
     * Get a array of updatable status keys
     *
     * @return array
     */
    public static function getUpdatableStatusKeys()
    {
        return [
            Item::STATUS_DRAFT,
            Item::STATUS_REVIEW,
            Item::STATUS_APPROVED,
            Item::STATUS_PUBLISHED,
            Item::STATUS_ARCHIVED,
        ];
    }

}
