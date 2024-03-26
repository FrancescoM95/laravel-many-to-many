@if ($project->exists)
    <form action="{{route('admin.projects.update', $project->id)}}" method="POST" enctype="multipart/form-data">
    @method('PUT')
@else
    <form action="{{route('admin.projects.store', $project->id)}}" method="POST" enctype="multipart/form-data">
@endif

@csrf
<div class="row g-4 justify-content-end py-5">
    <div class="col-5">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" class="form-control @error('title') is-invalid @elseif(old('title', '')) is-valid @enderror" id="title" name="title" placeholder="Inserisci titolo" value="{{old('title', $project->title)}}">
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
        <div class="form-text">
            Inserisci il titolo del progetto.
        </div>  
        @enderror
    </div>
    <div class="col-4">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" class="form-control" id="slug" value="{{ Str::slug(old('title', $project->title)) }}" disabled>
    </div>
    <div class="col-3">
        <label for="title" class="form-label">Linguaggi di Programmazione</label>
        <div class="form-group d-flex gap-3">
            <div class="form-check">
                <input class="form-check-input  @error('programming_languages') is-invalid @enderror" type="checkbox" id="htmlCheckbox" name="programming_languages[]" value="HTML" {{ $project->exists && strpos($project->programming_languages, 'HTML') !== false ? 'checked' : '' }}>
                <label class="form-check-label" for="htmlCheckbox">
                    HTML
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input  @error('programming_languages') is-invalid @enderror" type="checkbox" id="cssCheckbox" name="programming_languages[]" value="CSS" {{ $project->exists && strpos($project->programming_languages, 'CSS') !== false ? 'checked' : '' }}>
                <label class="form-check-label" for="cssCheckbox">
                    CSS
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input  @error('programming_languages') is-invalid @enderror" type="checkbox" id="jsCheckbox" name="programming_languages[]" value="JavaScript" {{ $project->exists && strpos($project->programming_languages, 'JavaScript') !== false ? 'checked' : '' }}>
                <label class="form-check-label" for="jsCheckbox">
                    JavaScript
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input  @error('programming_languages') is-invalid @enderror" type="checkbox" id="phpCheckbox" name="programming_languages[]" value="PHP" {{ $project->exists && strpos($project->programming_languages, 'PHP') !== false ? 'checked' : '' }}>
                <label class="form-check-label" for="phpCheckbox">
                    PHP
                </label>
            </div>
        </div>
    </div>

    <div class="col-9">
        <label for="image">Inesrisci url immagine</label>
        <input type="file" class="form-control @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror" id="image" name="image" placeholder="Carica immmagine" value="{{old('image', $project->image)}}">
        @error('image')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @else
        <div class="form-text">
            Inserisci l'immagine del progetto.
        </div>  
        @enderror
    </div>

    <div class="col-3">
        <label for="type_id">Seleziona Categoria</label>
        <select class="form-select @error('type_id') is-invalid @elseif(old('type_id', '')) is-valid @enderror" id="type_id" name="type_id">
            <option value="">Nessuna</option>
            @foreach ($types as $type){
                <option value="{{ $type->id }}" @if (old('type_id', $project->type?->id) == $type->id) selected @endif>{{ $type->label }}</option>
            }
            @endforeach
          </select>
          @error('type_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @else
            <div class="form-text">
                Inserisci la categoria del progetto.
            </div>  
            @enderror
    </div>
    
    <div class="col-12">
        <label for="content" class="form-label">Descizione</label>
        <textarea class="form-control @error('content') is-invalid @elseif(old('content', '')) is-valid @enderror" id="content" name="content" rows="10" placeholder="Inserisci descizione">{{old('content', $project->content)}}</textarea>
        @error('content')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @else
        <div class="form-text">
            Inserisci la descrizione del progetto.
        </div>  
        @enderror
    </div>
    <div class="col-3 d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-success">Salva</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </div>
</div>  
</form>
