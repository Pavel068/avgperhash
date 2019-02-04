<?php

namespace app;

interface HashHelperInterface
{
    public static function getHashesDifference(AverageHash $hash1, AverageHash $hash2);
}