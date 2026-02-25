<?php

$categories = [
    [
        'id' => 1,
        'name' => 'Root',
        'parent_id' => null,
    ],
    [
        'id' => 2,
        'name' => 'A',
        'parent_id' => 1,
    ],
    [
        'id' => 3,
        'name' => 'B',
        'parent_id' => 2,
    ],
    [
        'id' => 4,
        'name' => 'C',
        'parent_id' => 3,
    ],
];


function buildCategoriesTree($categories, $parentId = null) {
    $tree = [];
    foreach ($categories as $category) {

        if ($category['parent_id'] === $parentId) {
            $category['children'] = buildCategoriesTree($categories, $category['id']);;
            $tree[] = $category;
        }
    }
    return $tree;
}


print_r((buildCategoriesTree($categories)));
