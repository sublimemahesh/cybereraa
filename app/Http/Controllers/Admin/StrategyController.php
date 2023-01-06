<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Strategy;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
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

        $strategies = Strategy::whereIn('name', ['withdrawal_limits', 'max_withdraw_limit', 'minimum_payout_limit', 'payout_transfer_fee', 'p2p_transfer_fee'])->get();
        $withdrawal_limits = $strategies->where('name', 'withdrawal_limits')->first(null, new Strategy(['value' => '{"package": 300, "commission": 100}']));
        $max_withdraw_limit = $strategies->where('name', 'max_withdraw_limit')->first(null, new Strategy(['value' => 400]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));
        $payout_transfer_fee = $strategies->where('name', 'payout_transfer_fee')->first(null, new Strategy(['value' => 5]));
        $p2p_transfer_fee = $strategies->where('name', 'p2p_transfer_fee')->first(null, new Strategy(['value' => 2.5]));

        $withdrawal_limits = json_decode($withdrawal_limits->value, false, 512, JSON_THROW_ON_ERROR);

        return view('backend.admin.strategies.withdrawal.index', compact('withdrawal_limits', 'max_withdraw_limit', 'minimum_payout_limit', 'payout_transfer_fee', 'p2p_transfer_fee'));
    }

    /**
     * @throws JsonException
     */
    public function rankLevel()
    {
        $strategies = Strategy::whereIn('name', ['rank_level_count', 'rank_bonus_levels', 'rank_gift_levels', 'rank_package_requirement'])->get();

        $rank_level_count = $strategies->where('name', 'rank_level_count')->first(null, new Strategy(['value' => 7]));
        $rank_gift_levels = $strategies->where('name', 'rank_gift_levels')->first(null, new Strategy(['value' => '1,2']));
        $rank_bonus_levels = $strategies->where('name', 'rank_bonus_levels')->first(null, new Strategy(['value' => '3,4,5,6,7']));
        $rank_package_requirement = $strategies->where('name', 'rank_package_requirement')->first(null, new Strategy(['value' => '{"1":100,"2":250,"3":500,"4":1000,"5":2500,"6":5000,"7":10000}']));
        //$rank_bonus = $strategies->where('name', 'rank_bonus')->first(null, new Strategy(['value' => 10]));
        //$rank_gift = $strategies->where('name', 'rank_gift')->first(null, new Strategy(['value' => 5]));

        $rank_gift_levels = explode(',', $rank_gift_levels->value);
        $rank_bonus_levels = explode(',', $rank_bonus_levels->value);
        $rank_package_requirement = json_decode($rank_package_requirement->value, true, 512, JSON_THROW_ON_ERROR);

        return view('backend.admin.strategies.rank_level.index', compact('rank_level_count', 'rank_gift_levels', 'rank_bonus_levels', 'rank_package_requirement'));
    }

    /**
     * @throws JsonException
     */
    public function commissions()
    {
        $strategies = Strategy::whereIn('name', ['commission_level_count', 'commissions', 'rank_gift', 'rank_bonus'])->get();

        $commission_level_count = $strategies->where('name', 'commission_level_count')->first(null, new Strategy(['value' => 7]));
        $commissions = $strategies->where('name', 'commissions')->first(null, new Strategy(['value' => '{"1":25,"2":20,"3":15,"4":10,"5":5,"6":5,"7":5}']));
        $rank_gift = $strategies->where('name', 'rank_gift')->first(null, new Strategy(['value' => 5]));
        $rank_bonus = $strategies->where('name', 'rank_bonus')->first(null, new Strategy(['value' => 10]));

        $commissions = json_decode($commissions->value, false, 512, JSON_THROW_ON_ERROR);
        $total_percentage = array_sum(get_object_vars($commissions));
        $total_percentage += ($rank_gift->value + $rank_bonus->value);
        return view('backend.admin.strategies.commissions.index', compact('total_percentage', 'commission_level_count', 'commissions', 'rank_gift', 'rank_bonus'));
    }

    /**
     * @throws JsonException
     */
    public function payablePercentage()
    {
        $payable_percentages = Strategy::where('name', 'payable_percentages')->firstOr(fn() => new Strategy(['value' => '{"direct":0.332,"indirect":0.332,"rank_bonus":0.332}']));
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
        });

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'minimum_payout_limit'],
                ['value' => $validated['minimum_payout_limit']]
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
            'payout_transfer_fee' => ['required', 'numeric'],
            'p2p_transfer_fee' => 'required|numeric',
        ])->validate();

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'payout_transfer_fee'],
                ['value' => $validated['payout_transfer_fee']]
            );
        });

        DB::transaction(function () use ($validated) {
            Strategy::updateOrCreate(
                ['name' => 'p2p_transfer_fee'],
                ['value' => $validated['p2p_transfer_fee']]
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
            'rank_gift_levels' => ['required', 'integer', 'lte:6', 'gte:1'],
            'rank_bonus_levels' => ['required', 'integer', 'in:' . $request->get('rank_level_count') - $request->get('rank_gift_levels')],
        ])->validate();

        $rank_gift_levels = range(1, $validated['rank_gift_levels']);
        $rank_bonus_levels = range($validated['rank_gift_levels'] + 1, $validated['rank_level_count']);

        if ($validated['rank_level_count'] < (count($rank_gift_levels) + count($rank_bonus_levels))) {
            throw new \RuntimeException("Something went wrong with the level count");
        }

        DB::transaction(function () use ($rank_gift_levels, $validated) {
            Strategy::updateOrCreate(
                ['name' => 'rank_gift_levels'],
                ['value' => implode(',', $rank_gift_levels)]
            );
        });

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
            'commission_level_count' => ['required', 'integer', 'gte:2', 'lte:10'],
            'commissions' => ['required', 'array', 'size:' . $request->get('commission_level_count')],
            'commissions.*' => ['required', 'integer'],
            'rank_gift' => ['required', 'integer'],
            'rank_bonus' => ['required', 'integer'],
        ])->validate();

        unset($validated['commissions'][0]); // Make sure does not contain 0th index

        $total_percentage = array_sum($validated['commissions']) + $validated['rank_gift'] + $validated['rank_bonus'];

        if ($total_percentage > 100) {
            throw new RuntimeException('Total percentage must less than or equal to 100');
        }

        $commission_level_count = count($validated['commissions']);
        $commissions = json_encode($validated['commissions'], JSON_THROW_ON_ERROR);

        if ((int)$request->get('commission_level_count') !== $commission_level_count) {
            throw new RuntimeException('Something does not seem to be ok with commission level count');
        }

        $rank_bonus = $validated['rank_gift'];
        $rank_gift = $validated['rank_bonus'];

        DB::transaction(function () use ($rank_bonus, $rank_gift, $commissions, $commission_level_count) {
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

        $validated = Validator::make($request->all(), [
            'rank_package_requirement' => ['required', 'array', 'size:7'],
            'rank_package_requirement.1' => ['required', 'numeric'],
            'rank_package_requirement.2' => ['required', 'numeric'],
            'rank_package_requirement.3' => ['required', 'numeric'],
            'rank_package_requirement.4' => ['required', 'numeric'],
            'rank_package_requirement.5' => ['required', 'numeric'],
            'rank_package_requirement.6' => ['required', 'numeric'],
            'rank_package_requirement.7' => ['required', 'numeric'],
        ])->validate();

        $rank_package_requirement = json_encode($validated['rank_package_requirement'], JSON_THROW_ON_ERROR);
        DB::transaction(function () use ($rank_package_requirement, $validated) {
            Strategy::updateOrCreate(
                ['name' => 'rank_package_requirement'],
                ['value' => $rank_package_requirement]
            );
        });

        $json['status'] = true;
        $json['message'] = 'Rank commission minimum package values saved!';
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
            'rank_bonus' => 'required|numeric',
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