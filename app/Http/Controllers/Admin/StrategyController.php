<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Arr;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use JsonException;
use RuntimeException;
use Throwable;
use Validator;

class StrategyController extends Controller
{

    /**
     * @throws AuthorizationException
     * @throws JsonException
     */
    public function withdrawal()
    {
        $this->authorize('viewAny', Strategy::class);
        //dd(\Carbon::now()->englishDayOfWeek);
        $strategies = Strategy::whereIn('name', [
            'withdrawal_limits',
            'daily_max_withdrawal_limits',
            'withdrawal_days_of_week',
            'max_withdraw_limit',
            'minimum_payout_limit',
            'minimum_p2p_transfer_limit',
            'payout_transfer_fee',
            'staking_withdrawal_fee',
            'p2p_transfer_fee',
            'min_custom_investment',
            'max_custom_investment',
            'custom_investment_gas_fee',
        ])->get();

        $withdrawal_limits = $strategies->where('name', 'withdrawal_limits')->first(null, fn() => new Strategy(['value' => '{"package": 300, "commission": 100}']));
        $max_withdraw_limit = $strategies->where('name', 'max_withdraw_limit')->first(null, fn() => new Strategy(['value' => 400]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, fn() => new Strategy(['value' => 10]));
        $minimum_p2p_transfer_limit = $strategies->where('name', 'minimum_p2p_transfer_limit')->first(null, fn() => new Strategy(['value' => 5]));
        $payout_transfer_fee = $strategies->where('name', 'payout_transfer_fee')->first(null, fn() => new Strategy(['value' => 5]));
        $staking_withdrawal_fee = $strategies->where('name', 'staking_withdrawal_fee')->first(null, fn() => new Strategy(['value' => 5]));
        $p2p_transfer_fee = $strategies->where('name', 'p2p_transfer_fee')->first(null, fn() => new Strategy(['value' => 2.5]));

        $min_custom_investment = $strategies->where('name', 'min_custom_investment')->first(null, fn() => new Strategy(['value' => 10]));
        $max_custom_investment = $strategies->where('name', 'max_custom_investment')->first(null, fn() => new Strategy(['value' => 5000]));
        $custom_investment_gas_fee = $strategies->where('name', 'custom_investment_gas_fee')->first(null, fn() => new Strategy(['value' => 1]));

        $daily_max_withdrawal_limits = $strategies->where('name', 'daily_max_withdrawal_limits')->first(null, fn() => new Strategy(['value' => 100]));
        $withdrawal_days_of_week = $strategies->where('name', 'withdrawal_days_of_week')->first(null, fn() => new Strategy(['value' => '["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]']));

        $withdrawal_limits = json_decode($withdrawal_limits->value, false, 512, JSON_THROW_ON_ERROR);
        $withdrawal_days_of_week = json_decode($withdrawal_days_of_week->value, true, 512, JSON_THROW_ON_ERROR);

        return view('backend.admin.strategies.withdrawal.index',
            compact(
                'withdrawal_limits',
                'staking_withdrawal_fee',
                'max_withdraw_limit',
                'minimum_payout_limit',
                'minimum_p2p_transfer_limit',
                'payout_transfer_fee',
                'p2p_transfer_fee',
                'daily_max_withdrawal_limits',
                'withdrawal_days_of_week',
                'min_custom_investment',
                'max_custom_investment',
                'custom_investment_gas_fee',
            )
        );
    }

    /**
     * @throws JsonException
     * @throws AuthorizationException
     */
    public function rankLevel()
    {
        $this->authorize('viewAny', Strategy::class);

        $strategies = Strategy::whereIn('name', ['rank_level_count', 'rank_bonus_levels', 'rank_package_requirement'])->get();

        $rank_level_count = $strategies->where('name', 'rank_level_count')->first(null, fn() => new Strategy(['value' => 7]));
        $rank_bonus_levels = $strategies->where('name', 'rank_bonus_levels')->first(null, fn() => new Strategy(['value' => '3,4,5,6,7']));

        $rank_package_requirement = $strategies->where('name', 'rank_package_requirement')->first(null, fn() => new Strategy(['value' => '{"3":{"active_investment":"1000","total_team_investment":"5000"},"4":{"active_investment":"2500","total_team_investment":"10000"},"5":{"active_investment":"5000","total_team_investment":"25000"},"6":{"active_investment":"10000","total_team_investment":"50000"},"7":{"active_investment":"25000","total_team_investment":"100000"}}']));

        $rank_bonus_levels = explode(',', $rank_bonus_levels->value);
        $rank_package_requirement = json_decode($rank_package_requirement->value, true, 512, JSON_THROW_ON_ERROR);

        return view('backend.admin.strategies.rank_level.index', compact('rank_level_count', 'rank_bonus_levels', 'rank_package_requirement'));
    }

    /**
     * @throws JsonException
     * @throws AuthorizationException
     */
    public function rankGiftLevel()
    {
        $this->authorize('viewAny', Strategy::class);

        $strategies = Strategy::whereIn('name', ['rank_level_count', 'rank_gift_levels', 'rank_gift_requirements'])->get();

        $rank_level_count = $strategies->where('name', 'rank_level_count')->first(null, fn() => new Strategy(['value' => 7]));
        $rank_gift_levels = $strategies->where('name', 'rank_gift_levels')->first(null, fn() => new Strategy(['value' => '1,2,3,4,5,6,7']));

        $rank_gift_requirements = $strategies->where('name', 'rank_gift_requirements')->first(null, fn() => new Strategy(['value' => '{"1":{"total_investment":250,"total_team_investment":2000},"2":{"total_investment":500,"total_team_investment":12000},"3":{"total_investment":1000,"total_team_investment":75000},"4":{"total_investment":2500,"total_team_investment":400000},"5":{"total_investment":5000,"total_team_investment":2500000},"6":{"total_investment":10000,"total_team_investment":15000000},"7":{"total_investment":25000,"total_team_investment":100000000}}']));

        $rank_gift_levels = explode(',', $rank_gift_levels->value);
        $rank_gift_requirements = json_decode($rank_gift_requirements->value, true, 512, JSON_THROW_ON_ERROR);

        return view('backend.admin.strategies.rank_gift.index', compact('rank_level_count', 'rank_gift_levels', 'rank_gift_requirements'));
    }

    /**
     * @throws JsonException
     * @throws AuthorizationException
     */
    public function commissions()
    {
        $this->authorize('viewAny', Strategy::class);

        $strategies = Strategy::whereIn('name', ['trade_income', 'level_commission_requirement', 'commission_level_count', 'commissions', 'rank_gift', 'rank_bonus'])->get();

        $trade_income = $strategies->where('name', 'trade_income')->first(null, fn() => new Strategy(['value' => '{"1":"50","2":"25","3":"12.50","4":"6.25"}']));
        $trade_income = json_decode($trade_income?->value, true, 512, JSON_THROW_ON_ERROR);

        $commission_level_count = $strategies->where('name', 'commission_level_count')->first(null, fn() => new Strategy(['value' => 4]));
        $commissions = $strategies->where('name', 'commissions')->first(null, fn() => new Strategy(['value' => '{"1":"5","2":"2.5","3":"1.5","4":"1"}']));
        $rank_gift = $strategies->where('name', 'rank_gift')->first(null, fn() => new Strategy(['value' => 5]));
        $rank_bonus = $strategies->where('name', 'rank_bonus')->first(null, fn() => new Strategy(['value' => 10]));

        $level_commission_requirement = $strategies->where('name', 'level_commission_requirement')->first(null, fn() => new Strategy(['value' => 5]));
         
        $commissions = json_decode($commissions?->value, false, 512, JSON_THROW_ON_ERROR);
        $total_percentage = array_sum(get_object_vars($commissions));
        $total_percentage += ($rank_gift?->value + $rank_bonus?->value);

        return view('backend.admin.strategies.commissions.index', compact(
            'total_percentage',
            'trade_income',
            'level_commission_requirement',
            'commission_level_count',
            'commissions',
            'rank_gift',
            'rank_bonus'
        ));
    }

    /**
     * @throws JsonException
     * @throws AuthorizationException
     */
    public function payablePercentage()
    {
        $this->authorize('viewAny', Strategy::class);

        $payable_percentages = Strategy::where('name', 'payable_percentages')->firstOr(fn() => new Strategy(['value' => '{"direct":0.332,"indirect":0.332,"rank_bonus":0.332,"package":1}']));
        $payable_percentages = json_decode($payable_percentages->value, false, 512, JSON_THROW_ON_ERROR);

        return view('backend.admin.strategies.leverages.index', compact('payable_percentages'));
    }


    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function saveWithdraw(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', Strategy::class);

        $validated = Validator::make($request->all(), [
            'withdrawal_limits_package' => ['required', 'integer'],
            'withdrawal_limits_commission' => 'required|integer',
            'max_withdraw_limit' => 'required|integer',
            'minimum_payout_limit' => 'required|integer',
            'minimum_p2p_transfer_limit' => 'required|integer',
            'daily_max_withdrawal_limits' => 'required|integer',
            'withdrawal_days_of_week' => 'required|array|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        ])->validate();

        DB::transaction(function () use ($validated) {
            $withdrawal_limits = json_encode([
                'package' => $validated['withdrawal_limits_package'],
                'commission' => $validated['withdrawal_limits_commission'],
            ], JSON_THROW_ON_ERROR);

            Strategy::updateOrCreate(
                ['name' => 'withdrawal_limits'],
                ['value' => $withdrawal_limits]
            );

            $max_withdraw_limit = $validated['withdrawal_limits_package'] + $validated['withdrawal_limits_commission'];
            Strategy::updateOrCreate(
                ['name' => 'max_withdraw_limit'],
                ['value' => $max_withdraw_limit]
            );

            Strategy::updateOrCreate(
                ['name' => 'daily_max_withdrawal_limits'],
                [
                    'value' => $validated['daily_max_withdrawal_limits'],
                    'data_type' => 'double',
                    'comment' => 'Maximum usdt amount that allowed to withdraw for one day per user'
                ]
            );

            Strategy::updateOrCreate(
                ['name' => 'withdrawal_days_of_week'],
                [
                    'value' => json_encode($validated['withdrawal_days_of_week'], JSON_THROW_ON_ERROR),
                    'data_type' => 'double',
                    'comment' => 'Week days of that users can make withdraw requests'
                ]
            );
        });

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'minimum_payout_limit'],
                ['value' => $validated['minimum_payout_limit']]
            );
            Strategy::updateOrCreate(
                ['name' => 'minimum_p2p_transfer_limit'],
                [
                    'value' => $validated['minimum_p2p_transfer_limit'],
                    'data_type' => 'double',
                    'comment' => 'Minimum amount needed for request payout',
                ]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Withdrawal strategy saved!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function saveWithdrawFees(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', Strategy::class);

        $validated = Validator::make($request->all(), [
            'staking_withdrawal_fee' => ['required', 'numeric'],
            'payout_transfer_fee' => ['required', 'numeric'],
            'p2p_transfer_fee' => 'required|numeric',
            'min_custom_investment' => 'required|numeric|min:5',
            'max_custom_investment' => 'required|numeric|gte:min_custom_investment',
            'custom_investment_gas_fee' => 'required|numeric|gte:1|lte:100',
        ])->validate();

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'payout_transfer_fee'],
                ['value' => $validated['payout_transfer_fee']]
            );
        });

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'staking_withdrawal_fee'],
                [
                    'value' => $validated['staking_withdrawal_fee'],
                    'data_type' => 'double',
                    'comment' => 'Transaction fee for withdrawal from staking wallet'
                ]
            );
        });

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'p2p_transfer_fee'],
                ['value' => $validated['p2p_transfer_fee']]
            );
        });

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'min_custom_investment'],
                ['value' => $validated['min_custom_investment']]
            );
            Strategy::updateOrCreate(
                ['name' => 'max_custom_investment'],
                ['value' => $validated['max_custom_investment']]
            );
            Strategy::updateOrCreate(
                ['name' => 'custom_investment_gas_fee'],
                ['value' => $validated['custom_investment_gas_fee']]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Withdrawal Fee strategy saved!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function saveRankLevels(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', Strategy::class);

        $validated = Validator::make($request->all(), [
            'rank_level_count' => ['required', 'integer', 'in:7'],
            'rank_offset_levels' => ['required', 'integer', 'lte:6', 'gte:0'],
            'rank_bonus_levels' => ['required', 'integer', 'max:7'],
        ])->validate();

        //$rank_gift_levels = range(1, 7);
        $rank_bonus_levels = range($validated['rank_offset_levels'] + 1, $validated['rank_level_count']);

        if ((int)$validated['rank_level_count'] < count($rank_bonus_levels)) {
            throw new \RuntimeException("Something went wrong with the level count");
        }

//        DB::transaction(function () use ($rank_gift_levels, $validated) {
//            Strategy::updateOrCreate(
//                ['name' => 'rank_gift_levels'],
//                ['value' => implode(',', $rank_gift_levels)]
//            );
//        });

        DB::transaction(function () use ($rank_bonus_levels, $validated) {
            Strategy::updateOrCreate(
                ['name' => 'rank_bonus_levels'],
                ['value' => implode(',', $rank_bonus_levels)]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Rank Level & Benefit levels strategy saved!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function saveCommissions(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', Strategy::class);

        $validated = Validator::make($request->all(), [
            'trade_income_level_count' => ['required', 'integer', 'gte:1'],
            'trade_income' => ['required', 'array', 'size:' . $request->get('trade_income_level_count')],
            'trade_income.*' => ['required', 'numeric'],

            'level_commission_requirement' => ['required', 'integer', 'gte:1'],
            'commission_level_count' => ['required', 'integer', 'gte:1'],
            'commissions' => ['nullable', Rule::requiredIf($request->get('commission_level_count') > 0), 'array', 'size:' . $request->get('commission_level_count')],
            'commissions.*' => ['required', 'numeric'],

            'rank_gift' => ['required', 'numeric'],
            'rank_bonus' => ['required', 'numeric'],
        ])->validate();

        if (isset($validated['commissions']) && is_array($validated['commissions'])) {
            unset($validated['commissions'][0]); // Make sure does not contain 0th index
        } else {
            $validated['commissions'] = [];
        }

        $total_percentage = array_sum($validated['commissions']) + $validated['rank_gift'] + $validated['rank_bonus'];

        if ($total_percentage > 100) {
            throw new RuntimeException('Total percentage must less than or equal to 100');
        }

        $commission_level_count = count($validated['commissions']);
        if (!isset($validated['commissions']) || count($validated['commissions']) <= 0) {
            $commissions = '{}';
        } else {
            $commissions = json_encode($validated['commissions'], JSON_THROW_ON_ERROR);
        }

        if ((int)$request->get('commission_level_count') !== $commission_level_count) {
            throw new RuntimeException('Something does not seem to be ok with commission level count');
        }

        $trade_income = $validated['trade_income'];
        $level_commission_requirement = $validated['level_commission_requirement'];
        $rank_bonus = $validated['rank_bonus'];
        $rank_gift = $validated['rank_gift'];

        DB::transaction(function () use ($trade_income, $level_commission_requirement, $commission_level_count, $commissions, $rank_gift, $rank_bonus) {
            Strategy::updateOrCreate(
                ['name' => 'trade_income'],
                ['value' => $trade_income]
            );

            Strategy::updateOrCreate(
                ['name' => 'level_commission_requirement'],
                ['value' => $level_commission_requirement]
            );

            Strategy::updateOrCreate(
                ['name' => 'commission_level_count'],
                ['value' => $commission_level_count]
            );

            Strategy::updateOrCreate(
                ['name' => 'commissions'],
                ['value' => $commissions]
            );

            Strategy::updateOrCreate(
                ['name' => 'rank_gift'],
                ['value' => $rank_gift]
            );
            Strategy::updateOrCreate(
                ['name' => 'rank_bonus'],
                ['value' => $rank_bonus]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Commission levels & percentages strategy saved!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function savePackageRequirements(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', Strategy::class);

        //dd($request->all());
        $validated = Validator::make($request->all(), [
            'rank_package_requirement' => ['required', 'array'],
            'rank_package_requirement.*' => ['required', 'array'],
            'rank_package_requirement.*.active_investment' => ['required', 'numeric',],
            'rank_package_requirement.*.total_team_investment' => ['required', 'numeric',],
        ])->validate();

        $rank_package_requirement = json_encode($validated['rank_package_requirement'], JSON_THROW_ON_ERROR);
        DB::transaction(function () use ($rank_package_requirement, $validated) {
            Strategy::updateOrCreate(
                ['name' => 'rank_package_requirement'],
                ['value' => $rank_package_requirement]
            );
        });

        //$rank_gift_levels = range(1, 7);

        $pkg_levels = array_keys($validated['rank_package_requirement']);
        $rank_bonus_levels = range(Arr::first($pkg_levels), Arr::last($pkg_levels));

//        DB::transaction(function () use ($rank_gift_levels, $validated) {
//            Strategy::updateOrCreate(
//                ['name' => 'rank_gift_levels'],
//                ['value' => implode(',', $rank_gift_levels)]
//            );
//        });

        DB::transaction(function () use ($rank_bonus_levels, $validated) {
            Strategy::updateOrCreate(
                ['name' => 'rank_bonus_levels'],
                ['value' => implode(',', $rank_bonus_levels)]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Rank Bonus requirements updated!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function saveRankGiftInvestmentRequirement(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', Strategy::class);

        //dd($request->all());
        $validated = Validator::make($request->all(), [
            'rank_gift_requirements' => ['required', 'array'],
            'rank_gift_requirements.*' => ['required', 'array'],
            'rank_gift_requirements.*.total_investment' => ['required', 'numeric',],
            'rank_gift_requirements.*.total_team_investment' => ['required', 'numeric',],
        ])->validate();

        //dd($validated);
        $rank_gift_requirements = json_encode($validated['rank_gift_requirements'], JSON_THROW_ON_ERROR);
        DB::transaction(function () use ($rank_gift_requirements) {
            Strategy::updateOrCreate(
                ['name' => 'rank_gift_requirements'],
                ['value' => $rank_gift_requirements]
            );
        });

        $pkg_levels = array_keys($validated['rank_gift_requirements']);
        $rank_gift_levels = range(Arr::first($pkg_levels), Arr::last($pkg_levels));

        DB::transaction(function () use ($rank_gift_levels) {
            Strategy::updateOrCreate(
                ['name' => 'rank_gift_levels'],
                ['value' => implode(',', $rank_gift_levels)]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Rank Gift requirements updated!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function saveLeverages(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', Strategy::class);

        $validated = Validator::make($request->all(), [
            'direct' => ['required', 'numeric'],
            'indirect' => 'required|numeric',
            'package' => 'required|numeric',
            'rank_bonus' => 'nullable|numeric',
        ])->validate();

        $payable_percentages = json_encode($validated, JSON_THROW_ON_ERROR);
        DB::transaction(function () use ($payable_percentages) {
            Strategy::updateOrCreate(
                ['name' => 'payable_percentages'],
                ['value' => $payable_percentages]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Commissions Daily Leverage strategy saved!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
