<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\{ModuleTemplate}ServiceInterface as {ModuleTemplate}Service;
use App\Repositories\Interfaces\{ModuleTemplate}RepositoryInterface as {ModuleTemplate}Repository;
use App\Http\Requests\Store{ModuleTemplate}Request;
use App\Http\Requests\Update{ModuleTemplate}Request;
use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Http\Requests\Delete{ModuleTemplate}Request;
use App\Models\Language;

class {ModuleTemplate}Controller extends Controller
{
    protected ${moduleTemplate}Service;
    protected ${moduleTemplate}Repository;
    protected $nestedSet;
    protected $language;

    public function __construct({ModuleTemplate}Service ${moduleTemplate}Service, {ModuleTemplate}Repository ${moduleTemplate}Repository)
    {
        $this->{moduleTemplate}Service = ${moduleTemplate}Service;
        $this->{moduleTemplate}Repository = ${moduleTemplate}Repository;

        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });
    }

    private function initialize()
    {
        $this->nestedSet = new Nestedsetbie([
            'table' => '{tableName}',
            'foreignkey' => '{foreignKey}',
            'language_id' => $this->language,
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('modules', '{moduleView}.index');
        ${moduleTemplate}s = $this->{moduleTemplate}Service->paginate($request, $this->language);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'backend/library/switchery.js',
                'backend/library/changeStatus.js',
                'backend/library/selectAll.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css'
            ],
            'model' => '{ModuleTemplate}',
        ];
        $config['seo'] = __('message.{moduleTemplate}');

        $template = 'backend.{moduleView}.index';
        return view("backend.dashboard.layout", compact('template', 'config', '{moduleTemplate}s'));
    }

    public function create()
    {
        $this->authorize('modules', '{moduleView}.create');

        $config = $this->configData();

        $config['seo'] = config('apps.{moduleTemplate}');
        $config['method'] = 'create';

        $dropdown = $this->nestedSet->Dropdown();
        $template = 'backend.{moduleView}.store';
        return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
    }

    public function store(Store{ModuleTemplate}Request $request)
    {
        if ($this->{moduleTemplate}Service->create($request, $this->language)) {
            return redirect()->route('{moduleView}.index')->with("success", "Đã thêm nhóm người dùng");
        }
        return redirect()->route("{moduleView}.create")->with("error", "Đã xảy ra lỗi khi thêm nhóm người dùng");
    }

    public function edit($id)
    {
        $this->authorize('modules', '{moduleView}.update');

        $config = $this->configData();
        ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}ById($id, $this->language);
        $config['seo'] = config('apps.{moduleTemplate}');
        $config['method'] = 'edit';
        $dropdown = $this->nestedSet->Dropdown();
        $album = ${moduleTemplate}->album;
        $template = 'backend.{moduleView}.store';
        return view('backend.dashboard.layout', compact('template', 'config', '{moduleTemplate}', 'dropdown', 'album'));
    }

    public function update($id, Update{ModuleTemplate}Request $request)
    {
        if ($this->{moduleTemplate}Service->update($id, $request, $this->language)) {
            return redirect()->route('{moduleView}.index')->with('success', 'Cập nhật thông tin thành công.');
        }
        return redirect()->route('{moduleView}.edit', $id)->with('error', 'Đã xảy ra lỗi khi cập nhật. Vui lòng thử lại sau.');
    }

    public function delete($id)
    {
        $this->authorize('modules', '{moduleView}.destroy');

        ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}ById($id, $this->language);
        $config['seo'] = config('apps.{moduleTemplate}');
        $template = 'backend.{moduleView}.delete';
        return view("backend.dashboard.layout", compact('template', '{moduleTemplate}', 'config'));
    }

    public function destroy($id, Delete{moduleTemplate}Request $request)
    {
        if ($this->{moduleTemplate}Service->destroy($id, $this->language)) {
            return redirect()->route('{moduleView}.index')->with('success', 'Đã xoá nhóm người dùng');
        }
        return redirect()->route('{moduleView}.index')->with('error', 'Đã xảy ra lỗi khi xoá nhóm người dùng');
    }

    private function configData()
    {
        return [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/select2.js',
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/library/seo.js',
            ]
        ];
    }
}