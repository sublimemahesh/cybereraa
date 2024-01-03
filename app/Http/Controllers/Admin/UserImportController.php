<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserImportController extends Controller
{
    /**
     * @throws \JsonException
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

            if (count($errors) > 0 || count($failures) > 0) {
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
}
