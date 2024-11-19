<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Str;
use Validator;
use ZipArchive;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::orderbyDesc('id')->get();
        return view('admin.system.addons', ['addons' => $addons]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_code' => ['required', 'string'],
            'addon_files' => ['required', 'mimes:zip'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        if (!class_exists('ZipArchive')) {
            toastr()->error(translate('ZipArchive extension is not enabled'));
            return back();
        }
		/**
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $request->purchase_code)) {
            if (!preg_match("/^([d-u0-9]{10})-(([d-u0-9]{5})-){3}([d-u0-9]{10})$/i", $request->purchase_code)) {
                toastr()->error(translate('Invalid purchase code'));
                return back();
            }
        }
		*/
        try {
            $addonZipFile = storageFileUpload($request->file('addon_files'), 'temp/', 'local');
            $addonUploadPath = storage_path("app/{$addonZipFile}");

            $tempFolder = md5(Str::random(10) . time());
            $addonTempPath = storage_path("app/temp/{$tempFolder}");

            if (File::exists($addonTempPath)) {
                removeDirectory($addonTempPath);
            }

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        try {
            $zip = new ZipArchive;
            $res = $zip->open($addonUploadPath, ZipArchive::CREATE);
            if ($res != true) {
                throw new Exception(translate('Could not open the addon zip file'));
            }

            $res = $zip->extractTo($addonTempPath);
            if ($res == true) {
                removeFile($addonUploadPath);
            }

            $zip->close();

            $configFile = "{$addonTempPath}/config.json";
            if (!File::exists($configFile)) {
                throw new Exception(translate('Addon Config is missing'));
            }

            $config = json_decode(File::get($configFile), true);

            if ($config['type'] != "addon") {
                throw new Exception(translate('Invalid addon files'));
            }
			/**
            if (isInLiveServer()) {
                $response = purchaseCodeValidation($request->purchase_code, $config['item']['alias']);
                if (isset($response->status)) {
                    if ($response->status == "error") {
                        throw new Exception($response->message);
                    }
                } else {
                    throw new Exception(translate('Failed to validate the purchase code'));
                }
            }
			*/
            $scriptAlias = $config['script']['alias'];
            $scriptVersion = $config['script']['version'];

            if (strtolower(config('system.item.alias')) != strtolower($scriptAlias)) {
                throw new Exception(translate('Invalid action request'));
            }

            if (config('system.item.version') < $scriptVersion) {
                throw new Exception(translate("The :addon_name addon require :script_name version :script_version or above", [
                    'addon_name' => $config['name'],
                    'script_name' => $scriptAlias,
                    'script_version' => $scriptVersion,
                ]));
            }

            $addonDestinationPath = base_path($config['path']);
            if (File::exists($addonDestinationPath)) {
                removeDirectory($addonDestinationPath);
            }

            File::move($addonTempPath, $addonDestinationPath);

            $this->installAddonFiles($addonDestinationPath);

            $addon = Addon::updateOrCreate(['alias' => $config['alias']], [
                'name' => $config['name'],
                'version' => $config['version'],
                'thumbnail' => $config['thumbnail'],
                'path' => $config['path'],
                'action' => $config['action'],
                'status' => $config['status'],
            ]);

            if ($addon) {
                removeDirectory($addonTempPath);
                toastr()->success(translate('The addon has been installed successfully'));
                return back();
            }

        } catch (Exception $e) {
            removeFile($addonUploadPath);
            removeDirectory($addonTempPath);
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function installAddonFiles($addonPath)
    {
        $configFile = "{$addonPath}/config.json";
        $config = json_decode(File::get($configFile), true);
        $generalFiles = $config['general_files'];

        if (!empty($generalFiles)) {
            if (!empty($generalFiles['remove'])) {
                $removeDirectories = $generalFiles['remove']['directories'];
                if (!empty($removeDirectories)) {
                    foreach ($removeDirectories as $removeDirectory) {
                        removeDirectory(base_path($removeDirectory));
                    }
                }
                $removeFiles = $generalFiles['remove']['files'];
                if (!empty($removeFiles)) {
                    foreach ($removeFiles as $removeFile) {
                        removeFile(base_path($removeFile));
                    }
                }
            }
            if (!empty($generalFiles['create'])) {
                $createDirectories = $generalFiles['create']['directories'];
                if (!empty($createDirectories)) {
                    foreach ($createDirectories as $createDirectory) {
                        makeDirectory(base_path($createDirectory));
                    }
                }
            }
            if (!empty($generalFiles['copy'])) {
                $copyDirectories = $generalFiles['copy']['directories'];
                if (!empty($copyDirectories)) {
                    foreach ($copyDirectories as $copyDirectory) {
                        File::copyDirectory(base_path($copyDirectory['root']), base_path($copyDirectory['destination']));
                    }
                }
                $copyFiles = $generalFiles['copy']['files'];
                if (!empty($copyFiles)) {
                    foreach ($copyFiles as $copyFile) {
                        File::copy(base_path($copyFile['root']), base_path($copyFile['destination']));
                    }
                }
            }
        }

        if (!empty($config['database'])) {
            $databaseFiles = $config['database']['files'];
            if (!empty($databaseFiles)) {
                foreach ($databaseFiles as $databaseFile) {
                    if (File::exists(base_path($databaseFile))) {
                        $unprepared = DB::unprepared(File::get(base_path($databaseFile)));
                        if (!$unprepared) {
                            throw new Exception(translate("Cannot unprepared the database file"));
                        }
                    }
                }
            }
        }
    }

    public function update(Request $request, Addon $addon)
    {
        if (!in_array($request->status, [0, 1])) {
            return response()->json(['error' => translate('Failed to update the addon status')]);
        }
        $addon->status = $request->status ? 1 : 0;
        $addon->update();
        return response()->json(['success' => true]);
    }

}
