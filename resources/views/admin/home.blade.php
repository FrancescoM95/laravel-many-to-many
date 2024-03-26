@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="py-3">Projects</h1>
    <div>
      <a href="{{route('admin.projects.create')}}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Aggiungi progetto</a>
      <a href="{{route('admin.projects.trash')}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Cestino</a>
    </div>
  </div>
<div class="row g-5 py-3">
    @forelse ($projects as $project)
    <div class="col-4">
        <div class="card">
            <div class="card-header">
              <div class="d-flex gap-2 align-items-center">
                <h3 class="card-title">{{ $project->title }} </h3><span class="badge" style="background-color: {{ $project->type?->color }}">{{ $project->type? $project->type->label : '' }}</span>
              </div>
            </div>
            <div class="card-body">
                <img src="{{ $project->printImage() }}" class="card-img-top me-3 mb-3 img-fluid" alt="{{ $project->title }}">
                <p class="card-text overflow-auto" style="height: 300px">{{ $project->content }}</p>
            </div>
            <div class="card-footer">
                <div class="mb-2">
                  <strong>Linguaggi di programmazione:</strong><br>
                  @forelse ($project->technologies as $technology)
                  <span class="badge rounded-pill text-bg-{{ $technology->color }}">{{ $technology->label }}</span>
                  @empty
                    N.D.
                  @endforelse
                </div>
                <p class="card-text mb-1"><strong>Data creazione:</strong>  {{ $project->getCreatedAt() }}</p>
                <p class="card-text mb-1"><strong>Ultima modifica:</strong> {{ $project->getUpdatedAt() }}</p>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.projects.show', $project->id)}}" class="btn btn-sm btn-primary">
                      <i class="far fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.projects.edit', $project->id)}}" class="btn btn-sm btn-secondary">
                      <i class="fa-solid fa-pencil"></i>
                    </a>
                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" id="delete-form">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger"><i class="far fa-trash-can"></i></button>
                    </form>
                  </div>    
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Non ci sono progetti.</h5>
            </div>
        </div>
    </div>
    @endforelse
</div>


@endsection