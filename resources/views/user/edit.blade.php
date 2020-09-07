@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

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
                    <form action="{{route('user.update', $user->id)}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label>Password (Leave blank to keep your current password)</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password (Leave blank to keep your current password)</label>
                            <input type="password" class="form-control" name="confirmation_password">
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control select2" name="level">
                                <option value="">= Select Level =</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
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
    $('[name="level"]').val("{{$user->level}}");
    $('.select2').trigger('change');
</script>
@endsection
