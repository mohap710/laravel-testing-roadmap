<?php
// we can use the test() function to define a test case
test('89 is number', function () {
    expect(89)->toBeNumeric();
});
// we can use the it() function to define a test case it will be prefixed with 'it' in the test name
it('should be 10', function () {
    expect(10)->toBe(10);
});

// we can use the describe() function to group test cases together
describe('Sanity Test', function () {
    it('should be true', function () {
        expect(true)->toBeTrue();
    });

    it('should be false', function () {
        expect(false)->toBeFalse();
    });
});
