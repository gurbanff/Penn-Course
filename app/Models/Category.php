<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = ['order' => 'string'];

    protected $hidden = ['created_at'];

    public function scopeName($query, $name)
    {
        if (!is_null($name))
        return $query->orWhere("name", "LIKE", "%" . $name . "%");
    }

    public function scopeDescription($query, $description)
    {
        if (!is_null($description))
            return $query->where("description", "LIKE", "%" . $description . "%");
    }

    public function scopeSlug($query, $slug)
    {
        if (!is_null($slug))
            return $query->where("slug", "LIKE", "%" . $slug . "%");
    }

    public function scopeOrder($query, $order)
    {
        if (!is_null($order))
            return $query->where("order", $order);
    }

    public function scopeStatus($query, $status)
    {
        if (!is_null($status))
            return $query->where("status", "LIKE", "%" . $status . "%");
    }

    public function scopeFeatureStatus($query, $feature_status)
    {
        if (!is_null($feature_status))
            return $query->where("feature_status", "LIKE", "%" . $feature_status . "%");
    }

    public function scopeParentCategory($query, $parentID)
    {
        if (!is_null($parentID))
            $query->where('parent_id', $parentID);
    }

    public function scopeUser($query, $userID)
    {
        if (!is_null($userID))
        {
            $query->where("user_id", $userID);
        }
    }



    public function parentCategory():HasOne
    {
        return $this->hasOne(related: Category::class, foreignKey: "id", localKey: "parent_id");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, foreignKey: "id", localKey: "user_id");
    }

}
