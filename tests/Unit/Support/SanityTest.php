<?php

test('is 10', function () {
    expect(10)->toBe(10);
});

test('89 is number', function () {
    expect(89)->toBeNumeric();
});
