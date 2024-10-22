<?php

use App\Models\Category;

function getCategories()
{
    return Category::get()->toTree();
}
