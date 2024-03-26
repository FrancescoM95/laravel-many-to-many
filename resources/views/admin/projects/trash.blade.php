@extends('layouts.app')

@section('title', 'Cestino')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="py-3">Cestino</h1>
        <a href="{{route('admin.projects.index')}}" class="btn btn-primary">Lista Progetti</a>
    </div>

    <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Titolo</th>
            <th scope="col">Slug</th>
            <th scope="col" class="w-25">Descrizione</th>
            <th scope="col">Linguaggi</th>
            <th scope="col">Categoria</th>
            <th scope="col">Data creazione</th>
            <th scope="col">Ultima modifica</th>
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
                <td>{{ $project->programming_languages }}</td>
                <td class="text-center"><span class="badge" style="background-color: {{ $project->type?->color }}">{{ $project->type? $project->type->label : 'Nessuna' }}</span></td>
                <td>{{ $project->getUpdatedAt() }}</td>
                <td>{{ $project->getUpdatedAt() }}</td>
                <td>
                  <div class="d-flex gap-2 justify-content-end">
                    <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-rotate-left"></i></button>
                    </form>
                    
                     <a href="{{ route('admin.projects.edit', $project->id)}}" class="btn btn-sm btn-secondary">
                      <i class="fa-solid fa-pencil"></i>
                    </a> 
                   
                    <form action="{{ route('admin.projects.drop', $project->id) }}" method="POST" id="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-regular fa-trash-can"></i></button>
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

            const confirmation = confirm('Sei sicuro di voler eliminare definitivamente questo progetto?');

            if(confirmation) deleteForm.submit();
        });
    </script>
@endsection