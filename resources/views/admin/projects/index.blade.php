@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
      <h1 class="py-3">Projects</h1>
      <div>
        <a href="{{route('admin.projects.create')}}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Aggiungi progetto</a>
        <a href="{{route('admin.projects.trash')}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Cestino</a>
      </div>
    </div>

    <table class="table table-striped table-hover mb-5">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Titolo</th>
            <th scope="col">Slug</th>
            <th scope="col" class="w-25">Descrizione</th>
            <th scope="col">Linguaggi</th>
            <th scope="col" class="text-center">Categoria</th>
            <th scope="col" class="text-center">Data creazione</th>
            <th scope="col" class="text-center">Ultima modifica</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
            <tr>
                <th scope="row">{{ $project->id }}</th>
                <td>{{ $project->title }}</td>
                <td>{{ $project->slug }}</td>
                <td>{{ $project->content }}</td>
                <td>
                  @forelse ($project->technologies as $technology)
                  <span class="badge rounded-pill text-bg-{{ $technology->color }}">{{ $technology->label }}</span>
                  @empty
                    N.D.
                  @endforelse
                </td>
                <td class="text-center"><span class="badge" style="background-color: {{ $project->type?->color }}">{{ $project->type? $project->type->label : 'Nessuna' }}</span></td>
                <td class="text-center">{{ $project->getCreatedAt() }}</td>
                <td class="text-center">{{ $project->getUpdatedAt() }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('admin.projects.show', $project->id)}}" class="btn btn-sm btn-primary">
                      <i class="far fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.projects.edit', $project->id)}}" class="btn btn-sm btn-secondary">
                      <i class="fas fa-pencil"></i>
                    </a>
                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" id="delete-form">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger"><i class="far fa-trash-can"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
               <tr>
                <td colspan="9">
                  <h3 class="text-center">Non ci sono progetti.</h3>
                </td>
               </tr>
            
            @endforelse
          
        </tbody>
      </table>
@endsection

@section('scripts')
    <script>
        const deleteForm = document.getElementById('delete-form');

        deleteForm.addEventListener('submit', e => {
            e.preventDefault();

            const confirmation = confirm('Sei sicuro di voler spostare questo progetto nel cestino?');

            if(confirmation) deleteForm.submit();
        });
    </script>
@endsection