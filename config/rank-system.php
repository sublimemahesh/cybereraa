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
    'rank_level_count' => 7,

    /*
    |--------------------------------------------------------------------------
    | Rank activate requirement
    |--------------------------------------------------------------------------
    |
    | How many children needed to activate 1st rank and also
    | how many 1st rankers need to level up for 2nd rank, and
    | so on up to 5
    | DON'T EXCEED VALUE OVER 5
    |
    | Example: rank_eligibility_activate_at <= 5
    |
    */
    'rank_eligibility_activate_at' => 3,
];
