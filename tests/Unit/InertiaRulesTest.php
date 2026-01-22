<?php

test('rulebook contains new Inertia rules', function () {
    $path = __DIR__ . '/../../resources/skills/laravel-best-practices/references/rulebook.json';

    $json = json_decode(file_get_contents($path), true);

    expect($json)->toBeArray();

    $ids = array_column($json, 'id');

    expect($ids)->toContain('INRT-001');
    expect($ids)->toContain('INRT-002');
    expect($ids)->toContain('INRT-003');
    expect($ids)->toContain('INRT-004');
    expect($ids)->toContain('INRT-005');

    // Vue-specific Inertia rules should also be present
    expect($ids)->toContain('INRT-VUE-001');
    expect($ids)->toContain('INRT-VUE-002');
    expect($ids)->toContain('INRT-VUE-003');
    expect($ids)->toContain('INRT-VUE-004');
    expect($ids)->toContain('INRT-VUE-005');
});
