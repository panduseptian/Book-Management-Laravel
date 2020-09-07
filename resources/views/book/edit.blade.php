@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Author') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('book.update', $book->id)}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$book->name}}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" value="{{$book->description}}">
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <select class="form-control select2" name="author[]" multiple>
                                <option value="">= Select Author =</option>
                                @foreach ($authors as $author)
                                    <option value="{{$author->id}}">{{$author->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-success" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let data = @json($authorIDS);
    console.log(data);
    $('[name="author[]"]').val(data);
    $('.select2').trigger('change');
</script>
@endsection
