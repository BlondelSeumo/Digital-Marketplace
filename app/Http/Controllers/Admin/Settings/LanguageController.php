<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Classes\Language;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Validator;

class LanguageController extends Controller
{
    private $langPath;
    private $defaultLanguage;

    public function __construct()
    {
        $this->langPath = base_path("lang/");
        $this->defaultLanguage = env('DEFAULT_LANGUAGE');
    }

    public function index()
    {
        $languages = Language::all();
        return view('admin.settings.language.index', ['languages' => $languages]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language.code' => ['required', 'string', 'max:3'],
            'language.direction' => ['required', 'string', 'in:ltr,rtl'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $languageCode = $requestData['language']['code'];

        if (!array_key_exists($languageCode, Language::all())) {
            toastr()->error(translate('Invalid language name'));
            return back();
        }

        try {
            $update = Settings::updateSettings('language', $requestData['language']);
            if (!$update) {
                toastr()->error(translate('Updated Error'));
                return back();
            }

            if ($languageCode != $this->defaultLanguage) {
                $this->createNewLanguageFiles($languageCode);
            }

            setEnv('DEFAULT_LANGUAGE', @settings('language')->code);
            setEnv('DEFAULT_DIRECTION', @settings('language')->direction);

            Artisan::call('view:clear');

            toastr()->success(translate('Updated Successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

    }

    public function translates()
    {
        $language = Language::get($this->defaultLanguage);

        $translates = Translate::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $translates->where('key', 'like', $searchTerm)
                ->orWhere('value', 'like', $searchTerm);
        }

        $translates = $translates->orderbyDesc('id')->paginate(50);

        return view('admin.settings.language.translates', [
            'language' => $language,
            'translates' => $translates,
        ]);
    }

    public function translatesUpdate(Request $request)
    {
        foreach ($request->translates as $id => $value) {
            $translate = Translate::where('id', $id)->first();
            if ($translate) {
                $translate->value = $value;
                $translate->save();
            }
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    protected function createNewLanguageFiles($newLanguageCode)
    {
        try {
            $newLanguagePath = $this->langPath . $newLanguageCode;
            if (File::exists($newLanguagePath)) {
                File::deleteDirectory($newLanguagePath);
            }

            File::makeDirectory($newLanguagePath);

            $defaultLanguagePath = $this->langPath . $this->defaultLanguage;

            $defaultLanguageFiles = File::allFiles($defaultLanguagePath);
            foreach ($defaultLanguageFiles as $file) {
                $newFile = $newLanguagePath . '/' . $file->getFilename();
                if (!File::exists($newFile)) {
                    File::copy($file, $newFile);
                }
            }

            File::deleteDirectory($defaultLanguagePath);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
