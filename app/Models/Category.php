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

    public function parentCategory():HasOne
    {
        return $this->hasOne(related: Category::class, foreignKey: "id", localKey: "parent_id");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, foreignKey: "id", localKey: "user_id");
    }

}
