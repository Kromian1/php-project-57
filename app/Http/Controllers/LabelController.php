<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LabelController extends Controller
{
    protected const int PAGINATION_COUNT = 15;

    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    public function index()
    {
        $labels = Label::query()->paginate($this::PAGINATION_COUNT);

        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        $label = new Label();

        return view('labels.create', compact('label'));
    }

    public function store(LabelRequest $request)
    {
        $validated = $request->validated();

        $label = new Label();
        $label->fill($validated)->save();

        flash(__('flash.label.added'))->success()->important();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('labels.edit', ['label' => $label]);
    }

    public function update(LabelRequest $request, Label $label)
    {
        $validated = $request->validated();

        $label->fill($validated)->save();

        flash(__('flash.label.updated'))->success()->important();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('flash.label.cannot_delete'))->error()->important();

            return redirect()->route('labels.index');
        }

        $label->delete();
        flash(__('flash.label.deleted'))->success()->important();

        return redirect()->route('labels.index');
    }
}
