@extends('layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="row">
                  <div class="col-lg-6 col-xs-6">
                    <a style="text-decoration:none" href="{{url('produtos/')}}"><!-- link para itens cadastrados -->
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                          <h3>{{$itens}}</h3>
                              <h4>Itens cadastrados</h4>
                        </div>
                          <div class="icon">
                        <i class="fas fa-box"></i>
                        </div>
                      </div>
                    </a>
                </div>
                <div class="col-lg-6 col-xs-6">
                  <a style="text-decoration:none" href="{{url('users/')}}"><!-- link para usuários registrados -->
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>{{$user}}</h3>

                        <h4>Usuários Registrados</h4>
                      </div>
                      <div class="icon">
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-lg-6 col-xs-6">
                  <a style="text-decoration:none" href="{{url('supplier/')}}"><!-- link para fornecedores registrados -->
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>{{$suppliers}}</h3>

                        <h4>Fornecedores</h4>
                      </div>
                      <div class="icon">
                        <i class="fas fa-shipping-fast"></i>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-lg-6 col-xs-6">
                  <a style="text-decoration:none" href="{{url('categories/')}}"><!-- link para categorias registrados -->
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                      <div class="inner">
                        <h3>{{$categories}}</h3>

                        <h4>Categorias</h4>
                      </div>
                      <div class="icon">
                        <i class="fas fa-list-ul"></i>
                      </div>
                    </div>
                    </a>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
