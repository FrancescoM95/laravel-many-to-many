<?php

namespace App\Http\Controllers\Admin;


use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('updated_at')->orderByDesc('created_at')->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();

        $types = Type::select('label', 'id')->get();
        $technologies = Technology::select('label', 'id')->get();
        $prev_techs = $project->technologies->pluck('id')->toArray();
        return view('admin.projects.create', compact('project', 'types', 'technologies', 'prev_techs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => ['required', 'string', Rule::unique('projects')],
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio.',
                'title.unique' => 'Non possono esistere due progetti con lo stesso titolo.',
                'content.required' => 'La descrizione è obbligatoria.',
                'image.image' => 'Il file inserito non è un\'immagine.',
                'image.mimes' => 'Le estensioni consentite sono .png, .jpg, .jpeg.',
                'type_id.exists' => 'Categoria non valida.',
                'technologies.exists' => 'Linguaggi di programmazione non validi.'
            ]
        );

        $data = $request->all();

        $project = new Project();

        $project->fill($data);
        $project->slug = Str::slug($project->title);

        if (Arr::exists($data, 'image')) {
            $img_url = Storage::putFile('project_images', $data['image']);
            $project->image = $img_url;
        }

        $project->save();

        if (Arr::exists($data, 'technologies')) {
            $project->technologies()->attach($data['technologies']);
        }

        return redirect()->route('admin.projects.show', $project->id)
            ->with('type', 'success')
            ->with('message', 'Progetto creato correttamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $prev_techs = $project->technologies->pluck('id')->toArray();

        $types = Type::select('label', 'id')->get();
        $technologies = Technology::select('label', 'id')->get();
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'prev_techs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate(
            [
                'title' => ['required', 'string', Rule::unique('projects')->ignore($project->id)],
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id',
            ],
            [
                'title.required' => 'Il titolo è obbligatorio.',
                'title.unique' => 'Non possono esistere due progetti con lo stesso titolo.',
                'content.required' => 'La descrizione è obbligatoria.',
                'image.image' => 'Il file inserito non è un\'immagine.',
                'image.mimes' => 'Le estensioni consentite sono .png, .jpg, .jpeg.',
                'type_id.exists' => 'Categoria non valida.',
                'technologies.exists' => 'Linguaggi di programmazione non validi.',
            ]
        );

        $data = $request->all();


        if (Arr::exists($data, 'image')) {
            if ($project->image) Storage::delete($project->image);

            $img_url = Storage::putFile('project_images', $data['image']);
            $project->image = $img_url;
        }

        $project->update($data);

        if (Arr::exists($data, 'image')) {
            $img_url = Storage::putFile('project_images', $data['image']);
            $project->image = $img_url;
        }

        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        elseif (!Arr::exists($data, 'technologies') && $project->has('technologies')) $project->technologies()->detach();

        return to_route('admin.projects.show', $project->id)
            ->with('type', 'success')
            ->with('message', "Progetto modificato correttamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('type', 'info')->with('message', 'Progetto spostato nel cestino.');
    }

    // # SOFT DELETE

    public function trash()
    {
        $projects = Project::onlyTrashed()->get();

        return view('admin.projects.trash', compact('projects'));
    }

    public function restore(project $project)
    {
        $project->restore();

        return to_route('admin.projects.trash')
            ->with('type', 'success')
            ->with('message', "Progetto ripristinato con successo!");
    }

    public function drop(project $project)
    {
        if ($project->has('technologies')) $project->technologies()->detach();
        if ($project->image) Storage::delete($project->image);
        $project->forceDelete();

        return to_route('admin.projects.trash')
            ->with('type', 'danger')
            ->with('message', "Progetto eliminato definitivamente!");
    }
}
