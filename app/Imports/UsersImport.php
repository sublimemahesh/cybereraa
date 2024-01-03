<?php

namespace App\Imports;

use App\Models\User;
use DB;
use Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithEvents, WithValidation, WithHeadingRow
{
    use Importable, RegistersEventListeners;

    public function __construct(private User $parent)
    {
    }

    public function model(array $row)
    {
//        try {
        return DB::transaction(function () use ($row) {
            return tap(User::updateOrCreate(
                [
                    'username' => trim($row['user_id'])
                ],
                [
                    'is_onmax_user' => true,
                    'name' => trim($row['first_name']) . ' ' . trim($row['last_name']),
                    'email' => trim($row['email_address']),
                    //'phone' => $row['phone'] ?? null,
                    'super_parent_id' => $this->parent->id ?? config('fortify.super_parent_id'),
                    'password' => Hash::make(\Str::random(8)),
                ]
            ), function (User $user) use ($row) {
                $user->profile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        "nic" => $row['nic'] ? trim($row['nic']) : null,
                        "address" => $row['address'] ?? null,
                    ]
                );
//                $this->createSpecialBonus($user);
                $user->assignRole('user');
//                $this->createTeam($user);
            });
        });
//        } catch (\Throwable $e) {
//            return $e->getMessage();
//        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
//            'email' => Rule::in(['patrick@maatwebsite.nl']),

            // Above is alias for as it always validates in batches
            'user_id' => ['required', 'unique:users,username'],
            'first_name' => ['required'],
            'last_name' => ['required'], // required
            'email_address' => ['required', 'email'],
            'nic' => ['nullable'],
            'address' => ['nullable'],
        ];
    }
}
