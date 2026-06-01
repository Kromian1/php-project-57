<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::query()->paginate();

        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        $label = new Label();
        Gate::authorize('create', $label);

        return view('labels.create', compact('label'));
    }

    public function store(LabelRequest $request)
    {
        Gate::authorize('create', Label::class);

        $data = $request->validate([
            'name' => 'required|min:1|unique:labels,name',
            'description' => 'nullable',
        ]);

        $label = new Label();
        $label->fill($data)->save();

        flash(__('flash.label.added'))->success()->important();

        return redirect()->route('labels.index');
    }

    public function edit(int $id)
    {
        $label = Label::findOrFail($id);

        Gate::authorize('update', $label);

        return view('labels.edit', compact('label'));
    }

    public function update(LabelRequest $request, int $id)
    {
        $label = Label::findOrFail($id);

        Gate::authorize('update', $label);

        $data = $request->validate([
            'name' => 'required|min:1|unique:labels,name, {$label->id}',
            'description' => 'nullable',
        ]);

        $label->fill($data)->save();

        flash(__('flash.label.updated'))->success()->important();

        return redirect()->route('labels.index');
    }

    public function destroy(int $id)
    {
        $label = Label::findOrFail($id);

        Gate::authorize('delete', $label);

        if ($label->tasks()->exists()) {
            flash(__('flash.label.cannot_delete'))->error()->important();

            return redirect()->route('labels.index');
        }

        $label->delete();
        flash(__('flash.label.deleted'))->success()->important();

        return redirect()->route('labels.index');
    }
}
