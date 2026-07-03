<?php

declare(strict_types=1);

test('Section component can be instantiated', function () {
    $component = new Section('test-slug');

    expect($component)->toBeInstanceOf(Section::class);
});

test('PageContent component can be instantiated', function () {
    $component = new PageContent('test-slug');

    expect($component)->toBeInstanceOf(PageContent::class);
});
