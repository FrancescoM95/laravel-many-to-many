@extends('layouts.app')

@section('title', 'Project')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
      <h1 class="py-3">Projects</h1>
      <div>
        <a href="{{route('guest.home')}}" class="btn btn-primary"><i class="fas fa-angle-left fa-2xs"></i> Torna alla home</a>
      </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex">
            <img src="{{ $project->printImage() }}" class="card-img-top me-3 mb-3" alt="{{ $project->title }}">
            <div class="div">
              <div class="d-flex gap-2 align-items-center">
                <h3 class="card-title">{{ $project->title }} </h3><span class="badge" style="background-color: {{ $project->type?->color }}">{{ $project->type? $project->type->label : '' }}</span>
              </div>
              <p class="card-text">{{ $project->content }}</p>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <div>
              <strong>Linguaggi di programmazione:</strong>
              @forelse ($project->technologies as $technology)
              <span class="badge rounded-pill text-bg-{{ $technology->color }}">{{ $technology->label }}</span>
              @empty
                N.D.
              @endforelse
            </div>
  
            <div class="d-flex flex-column align-items-end gap-2">
              <div>
                  <strong>Data creazione:</strong>
                  {{ $project->getCreatedAt() }}
              </div>
              <div>
                  <strong>Data ultima modifica:</strong>
                  {{ $project->getUpdatedAt() }}
              </div>
            </div>
          </div>
          
          
        </div>
      </div>
@endsection
