<?php

namespace App\Http\Livewire;

use App\Filters\UpdatedFilter;
use App\Models\Posts;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Actions\RedirectAction;
use LaravelViews\Facades\Header;
use LaravelViews\Facades\UI;
use LaravelViews\Views\TableView;

class PostsTableView extends TableView
{
    public $searchBy = ['title', 'source','id'];

    public $sortBy = 'pub_date';

    public $sortOrder = 'desc';

    /**
     * Sets a model class to get the initial data
     */
    protected $model = Posts::class;

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            Header::title('ID')->sortBy('id'),
            Header::title('Title')->sortBy('title'),
            Header::title('Publish date')->sortBy('pub_date'),
            Header::title('Feed')->sortBy('source'),
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Posts model for each row
     */
    public function row($model): array
    {
        return [
            $model->id,
            UI::link($model->title, $model->link),
            $model->pub_date,
            $model->source,
        ];
    }

    protected function filters()
    {
        return [
            new UpdatedFilter,
        ];
    }

    protected function actionsByRow()
    {
        return [
            new RedirectAction('posts.show', 'See feed', 'eye'),
        ];
    }

}
