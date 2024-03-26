@if ($project->exists)
    <form action="{{route('admin.projects.update', $project->id)}}" method="POST" enctype="multipart/form-data">
    @method('PUT')
@else
    <form action="{{route('admin.projects.store', $project->id)}}" method="POST" enctype="multipart/form-data">
@endif

@csrf
<div class="row g-4 justify-content-end py-2">

    <div class="col-4">
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
 
    <div class="col-4">
        <label for="type_id" class="mb-2">Categoria</label>
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
                Seleziona la categoria del progetto.
            </div>  
            @enderror
    </div>

    <div class="col-12">
        <div class="form-label">Linguaggi di Programmazione</div>
        @foreach ($technologies as $technology)
        <div class="form-check form-check-inline" id="form-check">
            <input class="form-check-input" type="checkbox" name="technologies[]" id="{{ "technology-$technology->id" }}" value="{{ $technology->id}}" @if (in_array($technology->id, old('technologies', $prev_techs))) checked @endif>
            <label for="technology-{{ $technology->id }}" class="form-label">{{ $technology->label }}</label>
        </div>
        @endforeach
        @error('form-check')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
        <div class="form-text">
            Seleziona i linuguaggi di programmazione utilizzati nel progetto.
        </div>  
        @enderror
    </div>

    <div class="col-12">
        <label for="image" class="mb-2">Immagine</label>
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
    
    <div class="col-12">
        <label for="content" class="form-label">Descizione</label>
        <textarea class="form-control @error('content') is-invalid @elseif(old('content', '')) is-valid @enderror" id="content" name="content" rows="7" placeholder="Inserisci descizione">{{old('content', $project->content)}}</textarea>
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
    <div class="col-3 d-flex gap-2 justify-content-end align-items-center">
        <button type="submit" class="btn btn-success">Salva</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </div>
</div>  
</form>
