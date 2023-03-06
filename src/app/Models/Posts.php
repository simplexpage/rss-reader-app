<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Posts extends Model
{
    use HasFactory, Sortable;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'source',
        'source_url',
        'link',
        'description',
        'pub_date',
    ];

    public $sortable = [
        'title',
        'source',
        'source_url',
        'pub_date'
    ];
}
