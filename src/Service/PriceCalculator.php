<?php
// src/Service/PriceCalculator.php

namespace App\Service;

class PriceCalculator
{
    private const TVA = 0.20; // Taux de TVA à 20%

    public function calculatePriceWithTVA(float $priceHT): float
    {
        return $priceHT * (1 + self::TVA);
    }

    public function getTvaRate(): float
    {
        return self::TVA * 100;
    }
}