<?php

namespace Vironeer\Installer\App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Str;
use Validator;

class InstallController extends Controller
{
    public function redirect()
    {
        return redirect()->route('installer.requirements');
    }

    public function requirements()
    {
        if (config('system.install.requirements')) {
            return redirect()->route('installer.permissions');
        }

        $error = false;
        if (in_array(false, $this->extensionsArray())) {
            $error = true;
        }

        return view('installer::requirements', [
            'extensions' => phpExtensions(),
            'error' => $error,
        ]);
    }

    public function requirementsAction(Request $request)
    {
        if (in_array(false, $this->extensionsArray())) {
            return redirect()->route('installer.requirements');
        }

        Artisan::call('key:generate');
        setEnv('APP_ENV', 'production');
        setEnv('INSTALL_REQUIREMENTS', 1);

        return redirect()->route('installer.permissions');
    }

    public function permissions()
    {
        if (config('system.install.file_permissions')) {
            return redirect()->route('installer.license');
        }

        if (!config('system.install.requirements')) {
            return redirect()->route('installer.requirements');
        }

        $error = false;
        if (in_array(false, $this->permissionsArray())) {
            $error = true;
        }

        return view('installer::permissions', ['permissions' => filePermissions(), 'error' => $error]);
    }

    public function permissionsAction(Request $request)
    {
        if (in_array(false, $this->permissionsArray())) {
            return redirect()->route('installer.permissions');
        }

        setEnv('INSTALL_FILE_PERMISSIONS', 1);
        return redirect()->route('installer.license');
    }

    public function license()
    {
        if (config('system.install.license')) {
            return redirect()->route('installer.database.details');
        }

        if (!config('system.install.file_permissions')) {
            return redirect()->route('installer.requirements');
        }

        return view('installer::license');
    }

    public function licenseAction(Request $request)
    {
        if (empty($request->purchase_code)) {
            return redirect()->back()->withErrors([installer_trans('Purchase code is required')]);
        }
		setEnv('SYSTEM_LICENSE_TYPE', 2);
		setEnv('INSTALL_LICENSE', 1);
		return redirect()->route('installer.database.details');
    }

    public function databaseDetails()
    {
        if (config('system.install.database_info')) {
            return redirect()->route('installer.database.import');
        }

        if (!config('system.install.license')) {
            return redirect()->route('installer.license');
        }

        return view('installer::database.details');
    }

    public function databaseDetailsAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'db_host' => ['required', 'string'],
            'db_name' => ['required', 'string'],
            'db_user' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (str_contains($request->db_host, '#') || str_contains($request->db_name, '#') || str_contains($request->db_user, '#')) {
            return redirect()->back()->withErrors([installer_trans('Database details cannot contain a hashtag #')])->withInput();
        }

        try {
            if (!function_exists('curl_version')) {
                return redirect()->back()->withErrors([installer_trans('CURL does not exist in server')])->withInput();
            }
            if (!is_writable(base_path('.env'))) {
                return redirect()->back()->withErrors([installer_trans('.env file is not writable')])->withInput();
            }
            if (!@mysqli_connect($request->db_host, $request->db_user, $request->db_pass, $request->db_name)) {
                return redirect()->back()->withErrors([installer_trans('Incorrect database details')])->withInput();
            }
            setEnv('DB_HOST', $request->db_host);
            setEnv('DB_DATABASE', $request->db_name);
            setEnv('DB_USERNAME', $request->db_user);
            setEnv('DB_PASSWORD', $request->db_pass, true);
            setEnv('INSTALL_DATABASE_INFO', 1);
            return redirect()->route('installer.database.import');
        } catch (Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function databaseImport()
    {
        if (config('system.install.database_import')) {
            return redirect()->route('installer.complete');
        }

        if (!config('system.install.database_info')) {
            return redirect()->route('installer.database.details');
        }

        return view('installer::database.import');
    }

    public function databaseImportAction(Request $request)
    {
        if (!file_exists(base_path('database/sql/data.sql'))) {
            return redirect()->back()
                ->withErrors([installer_trans('SQL file is missing') . ' ' . base_path('database/sql/data.sql')])
                ->withInput();
        }
        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {
                $sql = base_path('database/sql/data.sql');
                $import = DB::unprepared(file_get_contents($sql));
                if ($import) {
                    setEnv('INSTALL_DATABASE_IMPORT', 1);
                    return redirect()->route('installer.complete');
                }
            } else {
                return redirect()->back()
                    ->withErrors([installer_trans('Could not find the database. Please check your configuration.')]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    public function databaseImportDownload(Request $request)
    {
        $sql = base_path('database/sql/data.sql');
        if (!file_exists($sql)) {
            return redirect()->back()
                ->withErrors([installer_trans('SQL file is missing') . ' ' . base_path('database/sql/data.sql')])
                ->withInput();
        }
        return response()->download($sql);
    }

    public function databaseImportSkip(Request $request)
    {
        setEnv('INSTALL_DATABASE_IMPORT', 1);
        return redirect()->route('installer.complete');
    }

    public function complete()
    {
        if (!config('system.install.database_import')) {
            return redirect()->route('installer.database.import');
        }

        return view('installer::complete');
    }

    public function completeAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_name' => ['required', 'string', 'max:200'],
            'website_url' => ['required', 'url'],
            'admin_path' => ['required', 'string', 'alpha_num'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'unique:users'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (str_contains($request->website_url, '#')) {
            return redirect()->back()->withErrors([installer_trans('Website URL cannot contain a hashtag #')])->withInput();
        }

        $admin = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => User::ROLE_ADMIN,
        ]);

        if ($admin) {
            $generalSettings = Settings::selectSettings('general');
            $generalSettings->site_name = $request->website_name;
            $generalSettings->site_url = $request->website_url;
            $update = Settings::updateSettings('general', $generalSettings);
            if ($update) {
                setEnv('APP_NAME', Str::slug($request->website_name, '_'));
                setEnv('APP_URL', $request->website_url);
                setEnv('SYSTEM_ADMIN_PATH', $request->admin_path, true);
                setEnv('INSTALL_COMPLETE', 1);
                return redirect(url($request->admin_path));
            } else {
                return redirect()->back()->withErrors([installer_trans('Failed to update general settings')])->withInput();
            }
        }
    }

    public function completeBack(Request $request)
    {
        setEnv('INSTALL_DATABASE_IMPORT', '');
        return redirect()->route('installer.database.import');
    }

    private function extensionsArray()
    {
        $extensionsArray = [];
        foreach (phpExtensions() as $extension) {
            $extensionsArray[] = extensionAvailability($extension);
        }

        return $extensionsArray;
    }

    private function permissionsArray()
    {
        $permissions = filePermissions();
        $permissionsArray = [];
        foreach ($permissions as $permission) {
            $permissionsArray[] = filePermissionValidation($permission);
        }

        return $permissionsArray;
    }
}
