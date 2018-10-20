@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('post.store') }}">
                        @csrf
                        <input type="hidden"  name="userid" value="{{ Auth::user()->id }}" />
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input type="text" name="title"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="" required /> 
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Body') }}</label>
                            <div class="col-md-6">
                                <textarea name="body" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" required ></textarea>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Post') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Timeline</div>
                <div class="card-body">
                @if($posts )
                    @foreach($posts as $post)
                    <div class="card mt-4">
                        <div class="card-body">
                        <h2>
                            <a href="{{--route('posts.show', $post->id) --}}"> </a>
                            <h3>{{$post->title}} </h3>
                            <span style="color:#f00">{{$post->name}} </span>
                            <p>{{ $post->body }}</p >
                            <a href="" class="btn btn-info">Edit</a>
                            <form onsubmit="return confirm('Are you sure you want to delete this post?')" class="d-inline-block" method="post" action="">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </h2>

                        </div>
                    </div>
                    @endforeach
                @endif
                    <div class="mt-4">
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
