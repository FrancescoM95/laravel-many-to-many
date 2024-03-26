@extends('layouts.app')

@section('title', 'Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center">
    <h1 class="py-3">New Projects</h1>
    <div>
      <a href="{{route('admin.projects.index')}}" class="btn btn-primary"><i class="fas fa-angle-left fa-2xs"></i> Torna alla lista</a>
    </div>
</div>

@include('includes.layouts.form')
<script>
  const titleField = document.getElementById('title');
  const slugField = document.getElementById('slug');

  titleField.addEventListener('blur', () =>{
    slugField.value = titleField.value.trim().toLowerCase().split(' ').join('-');
  })

</script>
@endsection
