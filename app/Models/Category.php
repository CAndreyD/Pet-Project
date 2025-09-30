<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель категории.
 *
 * Представляет категорию товаров с возможностью вложенности.
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Максимальная глубина вложенности категорий.
     */
    public const MAX_DEPTH = 3;

    /**
     * Разрешенные к массовому заполнению поля.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Родительская категория.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * Дочерние категории.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Товары, принадлежащие категории.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Рекурсивное удаление категории вместе с потомками.
     *
     * @return void
     */
    public function deleteWithChildren(): void
    {
        foreach ($this->children as $child) {
            $child->deleteWithChildren();
        }

        $this->delete();
    }

    /**
     * Рекурсивная связь с дочерними категориями.
     *
     * @return HasMany
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Вычислить глубину категории по ID родителя.
     *
     * @param int|null $parentId
     * @return int
     */
    public static function calculateDepth(?int $parentId): int
    {
        $depth = 0;

        while ($parentId !== null) {
            $parent = self::find($parentId);
            if (!$parent) {
                break;
            }

            $depth++;
            $parentId = $parent->parent_id;
        }

        return $depth;
    }
}
