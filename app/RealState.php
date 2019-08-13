<?php

namespace App;


use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    use FormatDates;
    protected $table = 'real_state';

    protected $fillable = [
        'user_id', 'title', 'description', 'cotent',
        'price', 'slug', 'bedrooms', 'bathrooms', 'property_area', 'total_property_area'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); //user_id
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }

    public function photos()
    {
        return $this->hasMany(RealStatePhoto::class);
    }
}
