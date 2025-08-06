<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    const MAX_DEPTH = 3;
    protected $guarded = [];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');

    }
    public function deleteWithChildren()
    {
        foreach ($this->children as $child) {
            $child->deleteWithChildren();
        }
        $this->delete();
    }
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
    public static function calculateDepth(?int $parentId): int
    {
        $depth = 0;

        while ($parentId !== null) {
            $parent = self::find($parentId);
            if (!$parent)
                break;

            $depth++;
            $parentId = $parent->parent_id;
        }

        return $depth;
    }



}
