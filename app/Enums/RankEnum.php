<?php

namespace App\Enums;

trait RankEnum
{
    public static function ranks()
    {
        return [
            1 => 'CYBER LINK',
            2 => 'CYBER PRO',
            3 => 'CYBER FUSION',
            4 => 'CYBER PRIME',
        ];
    }

    public static function info(): array
    {
        return [
            1 => [
                'name' => 'Cyber Link',
                'requirement' => 'USDT 1000 investment should be there, and USDT 5000 should be collected with 10 direct referrals.',
                'benefits' => 'When you get the member rank, you get a bonus profit of 5% of the amount 0f USDT 5000 you have.',
                'logo' => asset('assets/images/rank-logo.png')
            ],
            2 => [
                'name' => 'Cyber Pro',
                'requirement' => 'Those who have reached the C1 Rank within there level 4 should create 5 people.',
                'benefits' => 'When you get the bonus of 5% of the amount 0f USDT collected by the 5 people who reached C1 rank.',
                'logo' => asset('assets/images/rank-logo.png')
            ],
            3 => [
                'name' => 'Cyber Fusion',
                'requirement' => 'Those who have reached the C2 Rank within there level 4 should create 5 people.',
                'benefits' => 'An additional level called LEVEL 5 is open to you, and you will get a profit of 0.1% from the daily trading earned by those at that level.',
                'logo' => asset('assets/images/rank-logo.png')
            ],
            4 => [
                'name' => 'Cyber Prime',
                'requirement' => 'Those who have reached the C3 Rank within there level 4 should create 5 people.',
                'benefits' => [
                    'Two additional levels will open for you.
                     Total income will be earned in 4 levels.
                     You will get a seat in the grant row of the company',
                    'An additional level called LEVEL 6, LEVEL 7 is open to you, and you will get a profit of 0.1% from the daily trading earned by those at that new levels.'
                ],
                'logo' => asset('assets/images/rank-logo.png')
            ],
        ];
    }
}
