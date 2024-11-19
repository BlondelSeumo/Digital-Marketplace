<?php

namespace App\Http\Controllers\Admin\Navigation;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;
use Validator;

class FooterLinkController extends Controller
{
    public function index(Request $request)
    {
        $footerLinks = FooterLink::whereNull('parent_id')->with(['children' => function ($query) {
            $query->byOrder();
        }])->byOrder()->get();
        return view('admin.navigation.footer-links.index', ['footerLinks' => $footerLinks]);
    }

    public function nestable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the list')]);
        }

        $data = json_decode($request->ids, true);
        $i = 1;
        foreach ($data as $arr) {
            $menu = FooterLink::find($arr['id']);
            $menu->update([
                'order' => $i,
                'parent_id' => null,
            ]);
            if (isset($arr['children'])) {
                $sub_i = 1;
                foreach ($arr['children'] as $children) {
                    $menu = FooterLink::find($children['id']);
                    $menu->update([
                        'order' => $sub_i,
                        'parent_id' => $arr['id'],
                    ]);
                    $sub_i++;
                }
            }
            $i++;
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.navigation.footer-links.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'link_type' => ['required', 'integer', 'min:1', 'max:2'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $countLinks = FooterLink::all()->count();
        $footerLink = FooterLink::create([
            'name' => $request->name,
            'link' => $request->link,
            'link_type' => $request->link_type,
            'order' => ($countLinks + 1),
        ]);

        if ($footerLink) {
            toastr()->success(translate('Created Successfully'));
            return redirect()->route('admin.navigation.footer-links.index');
        }
    }

    public function edit(FooterLink $footerLink)
    {
        return view('admin.navigation.footer-links.edit', ['footerLink' => $footerLink]);
    }

    public function update(Request $request, FooterLink $footerLink)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'link_type' => ['required', 'integer', 'min:1', 'max:2'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $updateMenu = $footerLink->update([
            'name' => $request->name,
            'link' => $request->link,
            'link_type' => $request->link_type,
        ]);

        if ($updateMenu) {
            toastr()->success(translate('Updated Successfully'));
            return back();
        }
    }

    public function destroy(FooterLink $footerLink)
    {
        $footerLink->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
