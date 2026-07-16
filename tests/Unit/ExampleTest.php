<?php

test('that true is true', function () {
    expect(true)->toBeTrue();
});

test('that array with length of 3 that contains the number 41', function () {
    expect([1, 5, 41, 100])->toBeArray()->toHaveCount(4)->toContain(41);
});
