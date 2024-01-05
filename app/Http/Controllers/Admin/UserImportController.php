<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Select2UserResource;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Schema;
use JsonException;
use Log;
use Symfony\Component\HttpFoundation\Response;

class UserImportController extends Controller
{
    /**
     * @throws JsonException
     */
    public function import(Request $request)
    {
        abort_if(\Gate::denies('users.import-bulk'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $request->validate([
                'parent-user' => 'required|exists:users,id',
                'users-list' => 'required|file|mimes:xls,xlsx'
            ], [
                'parent-user.required' => 'The Parent User ID field is required.',
                'parent-user.exists' => 'The selected Parent User ID is invalid.',
                'users-list.required' => 'The Users List file is required.',
                'users-list.file' => 'The Users List must be a file.',
                'users-list.mimes' => 'The Users List must be a file of type: xls, xlsx.',
            ]);

            $parent = User::find($request->get('parent-user'));

            $import = new UsersImport($parent);
            $import->import($request->file('users-list'));
            $errors = $import->errors();
            $failures = $import->failures();

//            Excel::import(new UsersImport($parent), $request->file('users-list'));

            if (/*count($errors) > 0 || */ count($failures) > 0) {
                $log_data = json_encode(compact('errors', 'failures'), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
                \Log::channel('import_errors')->warning('Users Import Errors: | ' . $log_data);

                $json['status'] = false;
                $json['message'] = "There were errors found while importing. However, some users may have been imported successfully. Please check the logs for more details.";
                $json['errors'] = $errors;
                $json['failures'] = $failures;
                $json['icon'] = 'error';
                return response()->json($json, 422);
            }
            $json['status'] = true;
            $json['message'] = 'Import Successful';
            $json['icon'] = 'success';
            return response()->json($json);

        }
        return view('backend.admin.users.import');
    }

    public function findUsers($search_text): AnonymousResourceCollection
    {
        $users = User::where('username', 'LIKE', "%{$search_text}%")
            //->where('is_onmax_user', true)
            ->whereRelation('roles', 'name', 'user')
            ->get();

        return Select2UserResource::collection($users);
    }

    /**
     * @throws JsonException
     */
    public function removeUsers(Request $request)
    {
        abort_if(\Gate::denies('users.remove.bulk-import'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $request->validate([
                'user_id' => [
                    'required',
                    'exists:users,id',
//                    function ($attribute, $value, $fail) {
//                        // Add your custom validation logic here
//                        $userDoesntExists = User::where('id', $value)
//                            ->where('is_onmax_user', true)
//                            ->whereRelation('roles', 'name', 'user')
//                            ->doesntExist();
//
//                        if ($userDoesntExists) {
//                            $fail('The selected user is not a valid imported user.');
//                        }
//                    },
                ],
            ], [
                'user_id.required' => 'The User ID field is required.',
                'user_id.exists' => 'The selected User ID is invalid.',
            ]);

            $parent = User::find($request->get('user_id'));

            Log::channel('import_errors')->info("{$parent->username} Descendants have been Removed by admin: " . \Auth::user()->username, $parent->toArray());
//            \DB::transaction(function () use ($parent) {
            $parent->directSales()
                ->where('is_onmax_user', true)
                ->whereDoesntHave('directSales')
                ->whereDoesntHave('purchasedPackages')
//                ->chunk(200, function ($users) {
                ->get()
                ->each(function ($user) {
//                    foreach ($users as $user) {
                    Schema::disableForeignKeyConstraints();
                    $user->teams()->detach();
                    $user->deleteProfilePhoto();
                    $user->tokens->each->delete();
                    $user->wallet()->delete();
                    $user->transactions()->delete();
                    $user->profile()->forceDelete();
                    $user->forceDelete();
                    Schema::enableForeignKeyConstraints();
//                }
                });
//            });

            session()->flash('success', "Direct Users Removed Successfully.");

            session()->flash('warning', "Some users were not deleted because they have purchased packages or have referral users under there account. Imported Users without purchased packages and without referral users have been deleted along with their profiles and wallets.");

            $json['status'] = true;
            $json['message'] = 'Removed Successfully';
            $json['icon'] = 'success';
            return response()->json($json);

        }
        if (!session()->has('warning')) {
            session()->flash('info', 'Please Note: Some direct users may not delete if they have purchased packages or referral users under their account. ' .
                'Only imported users without purchased packages and not having referral users will be delete!.');
        }

        return view('backend.admin.users.remove-imported-users');
    }

}
