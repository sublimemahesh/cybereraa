<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'admin_wallet.viewAny', 'guard_name' => 'web'],
            ['name' => 'admin_wallet_transactions.viewAny', 'guard_name' => 'web'],
            ['name' => 'admin_wallet_withdrawal.viewAny', 'guard_name' => 'web'],
            ['name' => 'admin_wallet_withdrawal.create', 'guard_name' => 'web'],

            ['name' => 'company_users.viewAny', 'guard_name' => 'web'],

            ['name' => 'blogs.viewAny', 'guard_name' => 'web'],
            ['name' => 'blogs.create', 'guard_name' => 'web'],
            ['name' => 'blogs.update', 'guard_name' => 'web'],
            ['name' => 'blogs.delete', 'guard_name' => 'web'],

            ['name' => 'generate_daily_commission', 'guard_name' => 'web'],
            ['name' => 'commissions.viewAny', 'guard_name' => 'web'],

            ['name' => 'country.viewAny', 'guard_name' => 'web'],
            ['name' => 'country.create', 'guard_name' => 'web'],
            ['name' => 'country.update', 'guard_name' => 'web'],
            ['name' => 'country.delete', 'guard_name' => 'web'],

            ['name' => 'currency.viewAny', 'guard_name' => 'web'],
            ['name' => 'currency.create', 'guard_name' => 'web'],
            ['name' => 'currency.update', 'guard_name' => 'web'],
            ['name' => 'currency.delete', 'guard_name' => 'web'],

            ['name' => 'earnings.viewAny', 'guard_name' => 'web'],

            ['name' => 'kyc.viewAny', 'guard_name' => 'web'],
            ['name' => 'kyc.approve', 'guard_name' => 'web'],
            ['name' => 'kyc.reject', 'guard_name' => 'web'],

            ['name' => 'package.viewAny', 'guard_name' => 'web'],
            ['name' => 'package.create', 'guard_name' => 'web'],
            ['name' => 'package.update', 'guard_name' => 'web'],
            ['name' => 'package.delete', 'guard_name' => 'web'],

            ['name' => 'trader.viewAny', 'guard_name' => 'web'],
            ['name' => 'trader.create', 'guard_name' => 'web'],
            ['name' => 'trader.update', 'guard_name' => 'web'],
            ['name' => 'trader.delete', 'guard_name' => 'web'],

            ['name' => 'trader_transaction.viewAny', 'guard_name' => 'web'],
            ['name' => 'trader_transaction.create', 'guard_name' => 'web'],
            ['name' => 'trader_transaction.update', 'guard_name' => 'web'],
            ['name' => 'trader_transaction.delete', 'guard_name' => 'web'],

            ['name' => 'page.viewAny', 'guard_name' => 'web'],
            ['name' => 'page.create', 'guard_name' => 'web'],
            ['name' => 'page.update', 'guard_name' => 'web'],
            ['name' => 'page.delete', 'guard_name' => 'web'],

            ['name' => 'generate_daily_package_earnings', 'guard_name' => 'web'],
            ['name' => 'release_staking_interest', 'guard_name' => 'web'],
            ['name' => 'purchase_packages.viewAny', 'guard_name' => 'web'],

            ['name' => 'generate_monthly_rank_bonus', 'guard_name' => 'web'],
            ['name' => 'rank.viewAny', 'guard_name' => 'web'],

            ['name' => 'generate_daily_rank_bonus', 'guard_name' => 'web'],
            ['name' => 'rank_bonus.viewAny', 'guard_name' => 'web'],

            // ['name' => 'regenerate_rank_gifts', 'guard_name' => 'web'],
            ['name' => 'rank_gift.viewAny', 'guard_name' => 'web'],
            ['name' => 'rank_gift.issue_gift', 'guard_name' => 'web'],
            ['name' => 'rank_gift.make_qualify_gift', 'guard_name' => 'web'],

            ['name' => 'special_bonus.viewAny', 'guard_name' => 'web'],
            ['name' => 'special_bonus.issue_bonus', 'guard_name' => 'web'],

            ['name' => 'strategy.viewAny', 'guard_name' => 'web'],
            ['name' => 'strategy.update', 'guard_name' => 'web'],

            ['name' => 'support_ticket.viewAny', 'guard_name' => 'web'],
            ['name' => 'support_ticket.lowPriority', 'guard_name' => 'web'],
            ['name' => 'support_ticket.mediumPriority', 'guard_name' => 'web'],
            ['name' => 'support_ticket.highPriority', 'guard_name' => 'web'],
            ['name' => 'support_ticket.close', 'guard_name' => 'web'],
            ['name' => 'support_ticket.reopen', 'guard_name' => 'web'],
            ['name' => 'support_ticket.reply', 'guard_name' => 'web'],

            ['name' => 'support_ticket.category.viewAny', 'guard_name' => 'web'],
            ['name' => 'support_ticket.category.create', 'guard_name' => 'web'],
            ['name' => 'support_ticket.category.update', 'guard_name' => 'web'],
            ['name' => 'support_ticket.category.delete', 'guard_name' => 'web'],

            ['name' => 'support_ticket.priority.viewAny', 'guard_name' => 'web'],
            ['name' => 'support_ticket.priority.update', 'guard_name' => 'web'],
            ['name' => 'support_ticket.priority.delete', 'guard_name' => 'web'],

            ['name' => 'support_ticket.status.viewAny', 'guard_name' => 'web'],
            ['name' => 'support_ticket.status.update', 'guard_name' => 'web'],
            ['name' => 'support_ticket.status.delete', 'guard_name' => 'web'],

            ['name' => 'testimonial.viewAny', 'guard_name' => 'web'],
            ['name' => 'testimonial.publish', 'guard_name' => 'web'],
            ['name' => 'testimonial.create', 'guard_name' => 'web'],
            ['name' => 'testimonial.update', 'guard_name' => 'web'],
            ['name' => 'testimonial.delete', 'guard_name' => 'web'],

            ['name' => 'transactions.viewAny', 'guard_name' => 'web'],
            ['name' => 'transactions.edit-amount', 'guard_name' => 'web'],
            ['name' => 'transactions.approve', 'guard_name' => 'web'],
            ['name' => 'transactions.reject', 'guard_name' => 'web'],

            ['name' => 'place_pending_members_in_genealogy', 'guard_name' => 'web'],
            ['name' => 'users.genealogy', 'guard_name' => 'web'],

            ['name' => 'users.import-bulk', 'guard_name' => 'web'],
            ['name' => 'users.remove.bulk-import', 'guard_name' => 'web'],

            ['name' => 'users.add-new', 'guard_name' => 'web'],
            ['name' => 'users.viewAny', 'guard_name' => 'web'],
            ['name' => 'users.view.profile', 'guard_name' => 'web'],
            ['name' => 'users.manage-permissions', 'guard_name' => 'web'],
            ['name' => 'users.update', 'guard_name' => 'web'],
            ['name' => 'users.delete', 'guard_name' => 'web'],
            ['name' => 'users.suspend', 'guard_name' => 'web'],
            ['name' => 'users.activate-suspended', 'guard_name' => 'web'],
            ['name' => 'users.change-sponsor', 'guard_name' => 'web'],

            ['name' => 'admin.users.viewAny', 'guard_name' => 'web'],

            ['name' => 'wallet.viewAny', 'guard_name' => 'web'],

            ['name' => 'role.manage', 'guard_name' => 'web'],
            ['name' => 'permission.manage', 'guard_name' => 'web'],

            ['name' => 'wallet.topup', 'guard_name' => 'web'],
            ['name' => 'wallet.topup-history.viewAny', 'guard_name' => 'web'],
            ['name' => 'wallet.transfers-history.viewAny', 'guard_name' => 'web'],

            ['name' => 'withdraw.p2p.viewAny', 'guard_name' => 'web'],
            ['name' => 'withdrawals.viewAny', 'guard_name' => 'web'],
            ['name' => 'withdraw.approve', 'guard_name' => 'web'],
            ['name' => 'withdraw.reject', 'guard_name' => 'web'],

            ['name' => 'staking_package.viewAny', 'guard_name' => 'web'],
            ['name' => 'staking_package.create', 'guard_name' => 'web'],
            ['name' => 'staking_package.update', 'guard_name' => 'web'],
            ['name' => 'staking_package.delete', 'guard_name' => 'web'],

            ['name' => 'purchase_staking_plans.viewAny', 'guard_name' => 'web'],
            ['name' => 'stakingCancel.viewAny', 'guard_name' => 'web'],
            ['name' => 'stakingCancel.approve', 'guard_name' => 'web'],
            ['name' => 'stakingCancel.reject', 'guard_name' => 'web'],

            ['name' => 'popup-notice.viewAny', 'guard_name' => 'web'],
            ['name' => 'popup-notice.create', 'guard_name' => 'web'],
            ['name' => 'popup-notice.update', 'guard_name' => 'web'],
            ['name' => 'popup-notice.delete', 'guard_name' => 'web'],

        ];

        Permission::upsert($permissions, 'name');
    }
}
