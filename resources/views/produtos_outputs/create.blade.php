@extends('layouts.master')
@section('title','Entrada de novo Produto')
@section('content')

  @if($message = Session::get('success'))
    <div class='alert alert-success alert-dismissible fade show'>
        {{$message}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
  @elseif($message = Session::get('danger'))
    <div class='alert alert-danger alert-dismissible fade show'>
        {{$message}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>

  @endif

  @if(count($errors)>0)
    <div class="alert alert-danger alert-dismissible fade show">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </ul>
    </div >
  @endif
  <div class="card">
    <div class="card-header">
        <h4>Retirar Produto</h4>
    </div>
  <div class="card-body">

	<form method="POST" action="{{url('produtos_outputs')}}">
    @csrf

  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <label class="input-group-text" for="produto" name="produto">Produto</label>
    </div>
    <select class="custom-select" id="produto" name="produto">
      <option disabled selected>Selecione</option>
      @foreach($products as $product)
          <option value="{{$product->id}}">{{$product->titulo}}</option>
      @endforeach
    </select>
  </div>

  <div class="form-group mb-3">
		  <label for="nota">Nota:</label>
		  <textarea class="form-control" id="nota" name="nota" rows="1" placeholder="Digite uma breve descrição da aplicação final do Produto..." required></textarea>
	</div>
  <div class="form-group mb-3">
    <label for="quantidade">Quantidade</label>
     <input type="number" class="form-control" id="quantidade" name="quantidade" min="0" placeholder="0"/>
  </div>

	 	<button type="submit" class="btn btn-primary">Salvar</button>
    <a href="{{url('produtos_outputs')}}" class="btn btn-secondary">Cancelar</a>
</div>
</div>
	</form>
@endsection
