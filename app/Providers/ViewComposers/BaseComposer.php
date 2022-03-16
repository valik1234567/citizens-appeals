<?php

namespace App\Providers\ViewComposers;

use App\Models\Table;
use Illuminate\View\View;

class BaseComposer
{
    protected $tables;

    public function __construct(Table $tables)
    {
        $this->tables = $tables->all();
    }

    public function compose(View $view)
    {
        $view->with('tables', $this->tables);
    }
}
