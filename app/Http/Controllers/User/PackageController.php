<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Strategy;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JsonException;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::activePackages()->get();
        //$logged_user = Auth::user()->loadCount('purchasedPackages');
        //$is_gas_fee_added = $logged_user->purchased_packages_count <= 0;
//        dd(json_encode($packages->pluck('slug')));
        return view('backend.user.packages.index', compact('packages'));
    }

    public function custom()
    {
        $strategies = Strategy::whereIn('name', ['min_custom_investment', 'max_custom_investment', 'custom_investment_gas_fee'])->get();
        $min_custom_investment = $strategies->where('name', 'min_custom_investment')->first(null, fn() => new Strategy(['value' => 10]));
        $max_custom_investment = $strategies->where('name', 'max_custom_investment')->first(null, fn() => new Strategy(['value' => 5000]));
        $custom_investment_gas_fee = $strategies->where('name', 'custom_investment_gas_fee')->first(null, fn() => new Strategy(['value' => 1]));

        $package = new Package([
            'name' => 'Custom',
            'slug' => 'custom',
            'currency' => 'USDT',
            'amount' => $min_custom_investment?->value,
            'gas_fee' => $custom_investment_gas_fee?->value,
            'month_of_period' => 30,
            'daily_leverage' => 1,
            'is_active' => 1,
        ]);
        return view('backend.user.packages.custom-amount-deposit', compact('package', 'min_custom_investment', 'max_custom_investment', 'custom_investment_gas_fee'));
    }

    /**
     * @throws JsonException
     */
    public function active(Request $request)
    {
        $activePackages = Auth::user()->activePackages;
        $activePackages->load('transaction');
        $activePackages->loadSum('earnings', 'amount');
// dd($activePackages);
        $withdrawal_limits = Strategy::where('name', 'withdrawal_limits')->first();
        $withdrawal_limits = json_decode($withdrawal_limits->value ?? '[]', false, 512, JSON_THROW_ON_ERROR);
        return view('backend.user.packages.active', compact('activePackages'));
    }

    public function manualPurchaseCustom(Request $request, float $amount, User|null $purchase_for = null)
    {
        $strategies = Strategy::whereIn('name', ['min_custom_investment', 'max_custom_investment', 'custom_investment_gas_fee'])->get();
        $custom_investment_gas_fee = $strategies->where('name', 'custom_investment_gas_fee')->first(null, fn() => new Strategy(['value' => 1]));

        $package = new Package([
            'name' => 'Custom',
            'slug' => 'custom',
            'currency' => 'USDT',
            'amount' => $amount,
            'gas_fee' => ($amount * $custom_investment_gas_fee?->value) / 100,
            'month_of_period' => 30,
            'daily_leverage' => 1,
            'is_active' => 1,
        ]);

        return $this->manualPurchase($request, $package, $purchase_for);
    }

    public function manualPurchase(Request $request, Package $package, User|null $purchase_for = null)
    {
        if ($purchase_for !== null) {
            $user = $purchase_for;
            $purchased_by = Auth::user();
        } else {
            $user = Auth::user();
            $purchased_by = $user;
        }

        $user->loadMax('purchasedPackages', 'invested_amount');
        $max_amount = $user->purchased_packages_max_invested_amount;
        if (Gate::inspect('purchase', [$package, $max_amount])->denied()) {
            session()->flash('error', "Please select a package amount is higher than or equal to USDT " . $user->purchased_packages_max_invested_amount);
        }

        return view('backend.user.packages.manual-purchase', compact('package', 'purchase_for', 'max_amount'));
    }
}
