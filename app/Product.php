<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    //Import libreria
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.title' => 20,
            'brands.name' => 15,
            'sub_categories.name' => 10,
            'categories.name' => 5,
        ],
        'joins' => [
            'brands' => ['brands.id','products.brand_id'],
            'sub_categories' => ['sub_categories.id','products.sub_category_id'],
            'categories' => ['categories.id','sub_categories.category_id'],
        ],
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'new_product',
        'offer',
        'stock',
        'current',
        'brand_id',
        'sub_category_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['brand','category','string_new_product','string_discount','string_stock','string_price'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s'
    ];

    //Mutadores
    public function getBrandAttribute()
    {
        return Brand::find($this->brand_id)->name;
    }

    public function getCategoryAttribute()
    {
        $sub_category = SubCategory::find($this->sub_category_id);
        $category = Category::find($sub_category->category_id);
        return "{$category->name}/{$sub_category->name}";
    }

    public function getStringNewProductAttribute()
    {
        return $this->new_product === 1 ? 'NUEVO' : 'HISTORICO';
    }

    public function getStringDiscountAttribute()
    {
        return "Oferta: {$this->discount}%";
    }

    public function getStringStockAttribute()
    {
        return $this->stock > 0 ? 'EN INVENTARIO' : 'AGOSTADO';
    }

    public function getStringPriceAttribute()
    {
        $price = number_format($this->price,2,'.',',');
        return "Q {$price}";
    }

    public function getNameCompleteAttribute()
    {
        $brand = Brand::find($this->brand_id)->name;
        $sub_category = SubCategory::find($this->sub_category_id);
        $category = Category::find($sub_category->category_id);
        return "{$this->title}, {$brand}, {$category->name}/{$sub_category->name}";
    }

    public function getFormatoFechaAttribute()
    {
        $date = date('d/m/Y h:i:s', strtotime($this->updated_at));
        return "Última actualización {$date}";
    }

    //Relaciones
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function product_comments()
    {
        return $this->hasMany(ProductComment::class);
    }
}
