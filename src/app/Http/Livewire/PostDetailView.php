<?php

namespace App\Http\Livewire;

use App\Models\Posts;
use LaravelViews\Views\DetailView;

class PostDetailView extends DetailView
{
    protected $modelClass = Posts::class;

    public $title = "Post detail";
    public $subtitle = "My custom subtitle";

    public function heading($model)
    {
        return [
            "Post # {$model->id}",
            "This is the detail view"
        ];
    }

    /**
     * @param $model Posts instance
     * @return Array Array with all the detail data or the components
     */
    public function detail($model)
    {
        return [
            'Title' => $model->title,
            'Description' => $model->description,
            'Link' => $model->link,
            'Publish date' => $model->pub_date,
            'Source' => $model->source,
            'Source url' => $model->source_url,
        ];
    }
}
