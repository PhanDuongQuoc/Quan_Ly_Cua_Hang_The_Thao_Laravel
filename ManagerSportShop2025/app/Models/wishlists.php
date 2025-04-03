<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

 class wishlists extends Model{
    protected $table = "wishlists";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'product_id',
    ];
    public function product(){
        return $this->belongsTo('App\Models\product','id_product','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


 }