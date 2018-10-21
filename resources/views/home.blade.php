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
                <div class="card-body" id="vue-app">
                
                    <div v-for="post of posts" class="card mt-4" >
                        <div class="card-body">
                        <h2>
                            <h3>@{{ post.title}} </h3>
                            <span style="color:#f00">@{{ post.name}} </span>
                            <p>@{{ post.body }}</p >
                            <button v-on:click="showModal=true;" class="btn btn-info" id="show-modal" > Edit</button>
                            <form onsubmit="return confirm('Are you sure you want to delete this post?')" class="d-inline-block" method="post" action="{{ route('post.destroy')}}">
                            @csrf
                            @method('delete')
                            <input type="hidden"  name="id" v-model="post.id" value='' />
                            <button type="submit" class="btn btn-danger" v-on:click="postDelete">Delete</button>
                            </form>
                        </h2>
                        </div>
                    </div>
                    <ul v-if="errors && errors.length">
                        <li v-for="error of errors">
                        @{{error.message}}
                        </li>
                    </ul>
                
               
                    <div v-if="showModal" @close="showModal=false" class="modal fade">
                        <form action="" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value=''>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-info" v-on:click="postUpdate">update the post</button>
                        </div>
                        </form>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>




<script>
var app1 = new Vue({
    el: '#vue-app',
	data:{
      posts: [],
      postId:'',
	  postBody:'',
	  postTitle:'',
      errors: [],
      showModal: false
    },
	  // Fetches posts when the component is created.
	created() {
		axios.get("/posts")
		.then(response => {
		  // JSON responses are automatically parsed.
		  this.posts = response.data
          
		})
		.catch(e => {
		  this.errors.push(e)
		})
	},
	methods : {
		   // Pushes posts to the server when called.
		postUpdate() {	
			axios.post('/post/'+ this.postId, {
			  title: this.postTitle,
			  body: this.postBody
			})
			.then(response => {})
			.catch(e => {
			  this.errors.push(e)
			})

		},
        postDelete() {	
			axios.post('/post/destroy', {
			  id: this.postId
			})
			.then(response => {})
			.catch(e => {
			  this.errors.push(e)
			})

		}
	}
});
</script>
@endsection
