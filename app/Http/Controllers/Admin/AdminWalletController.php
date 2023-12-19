<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use App\Models\User;
use DB;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminWalletController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_wallet.viewAny'), Response::HTTP_FORBIDDEN);

        $admin_wallets = AdminWallet::all();

        return view('backend.admin.admin-wallets.wallets', compact('admin_wallets'));
    }

    public function companyUsers(Request $request)
    {
        abort_if(Gate::denies('company_users.viewAny'), Response::HTTP_FORBIDDEN);

        $company_users_id = [3, 4, 5, 6];

        $company_users = User::select([
            'id',
            'username',
            'name',
            'email',
            DB::raw("(SELECT COALESCE(SUM(invested_amount), 0) FROM purchased_package WHERE user_id = users.id AND status NOT IN ('PENDING')) as total_sale_amount"),
            DB::raw("(SELECT COALESCE(SUM(earnings.amount), 0) FROM earnings WHERE  user_id = users.id AND earnings.status = 'RECEIVED' AND earnings.type NOT IN ('P2P', 'RANK_BONUS', 'RANK_GIFT', 'TEAM_BONUS', 'SPECIAL_BONUS', 'STAKING')) as total_earnings"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM commissions WHERE user_id = users.id AND parent_id IS NULL) as total_commissions"),
            DB::raw("(SELECT COALESCE(SUM(paid), 0) FROM commissions WHERE user_id = users.id AND status = 'QUALIFIED') as total_qualified_commissions"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM commissions WHERE user_id = users.id AND status = 'DISQUALIFIED') as lost_commissions"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM earnings WHERE user_id = users.id AND status = 'RECEIVED' AND type = 'PACKAGE') as total_package_earnings"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM earnings WHERE user_id = users.id AND status = 'RECEIVED' AND type = 'DIRECT') as total_direct_commission_earnings"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM earnings WHERE user_id = users.id AND status = 'RECEIVED' AND type = 'INDIRECT') as total_indirect_commission_earnings"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM earnings WHERE user_id = users.id AND status = 'RECEIVED' AND type = 'SPECIAL_BONUS') as total_special_bonus_earnings"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM earnings WHERE user_id = users.id AND status = 'RECEIVED' AND type = 'TRADE_DIRECT') as total_trade_earnings"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM earnings WHERE user_id = users.id AND status = 'RECEIVED' AND type = 'TRADE_INDIRECT') as total_indirect_earnings"),
            DB::raw("(SELECT COALESCE(SUM(balance), 0) FROM wallets WHERE user_id = users.id) as total_available_wallet_balance"),
            DB::raw("(SELECT COALESCE(SUM(topup_balance), 0) FROM wallets WHERE user_id = users.id) as total_available_wallet_topup_balance"),
            DB::raw("(SELECT COALESCE(SUM(withdraw_limit), 0) FROM wallets WHERE user_id = users.id) as total_withdraw_limit_wallet_balance"),
            DB::raw("(SELECT COALESCE(SUM(amount), 0) FROM withdraws WHERE user_id = users.id AND status = 'SUCCESS' AND type IN ('BINANCE', 'MANUAL')) as total_withdraw")
        ])
            ->whereIn('id', $company_users_id) // Add any other conditions you need
            ->get();

        return view('backend.admin.admin-wallets.company-users-report', compact('company_users'));
    }
}
