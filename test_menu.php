<?php

require_once 'vendor/autoload.php';

use UI\Http\Shared\Menu\MenuItem;

try {
    $child = new MenuItem('Liste', null, 'admin_animal_index');
    $parent = new MenuItem(
        'Animal', 
        'ti ti-box', 
        'admin_animal_index', 
        'admin_animal_', 
        [$child]
    );

    // Test exact match
    assert($child->isActive('admin_animal_index') === true);
    assert($parent->isActive('admin_animal_index') === true);

    // Test prefix match
    assert($parent->isActive('admin_animal_new') === true);
    assert($parent->isActive('admin_animal_edit') === true);
    assert($child->isActive('admin_animal_new') === false); // Child has no prefix

    // Test mismatch
    assert($parent->isActive('admin_client_index') === false);

    // Test recursion
    $subChild = new MenuItem('Edit', null, 'admin_animal_edit');
    $childWithChild = new MenuItem('Actions', null, null, null, [$subChild]);
    $root = new MenuItem('Root', null, null, null, [$childWithChild]);

    assert($root->isActive('admin_animal_edit') === true);

    echo "MENU ITEM TEST SUCCESSFUL\n";
} catch (\Exception $e) {
    echo "MENU ITEM TEST FAILED: " . $e->getMessage() . "\n";
    exit(1);
} catch (\Error $e) {
    echo "MENU ITEM TEST ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
