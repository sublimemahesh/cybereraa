<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Available Rank Levels
    |--------------------------------------------------------------------------
    |
    | This value sets the available rank levels for the system
    |
    |
    */
    'rank_level_count' => 10,

    /*
    |--------------------------------------------------------------------------
    | Rank activate requirement
    |--------------------------------------------------------------------------
    |
    | How many children needed to activate 1st rank and also
    | how many 1st rankers need to level up for 2nd rank, and
    | so on up to max rank_level_count
    | DON'T EXCEED VALUE OVER rank_level_count
    |
    | Example: rank_eligibility_activate_at <= rank_level_count
    |
    */
    'rank_eligibility_activate_at' => 3,
];
