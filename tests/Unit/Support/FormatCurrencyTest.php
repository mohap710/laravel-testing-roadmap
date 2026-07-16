<?php

declare(strict_types=1);

beforeEach(function () {
    $this->formatCurrency = new \App\Support\FormatCurrency();
});

describe('format currency', function () {
    it('format cents to string when 0 is passed', function () {
        expect($this->formatCurrency->toString(0))->toBe("0.00");
    });

    it('format cents to string when negative number is passed', function () {
        expect($this->formatCurrency->toString(-1000))->toBe("-10.00");
    });

    it('format cents to string when big number is passed', function () {
        expect($this->formatCurrency->toString(150000))->toBe("1,500.00");
    });
});
