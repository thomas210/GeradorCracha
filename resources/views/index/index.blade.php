@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br />
            @if (\Session::has('warning'))
                <div class="alert alert-warning alert-dismissible fade show text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>{{ \Session::get('warning') }}</strong>
                </div><br />
            @endif

            <div class="card">
                <div class="card-header headerNTI">{{ __('Insiras as informações abaixo') }}</div>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <span class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong>{{ $error }}</strong>
                        </span>
                    @endforeach
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ action('CrachaController@createCracha') }}" enctype="multipart/form-data">
                        @csrf
                      
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="template" class="col-md-4 col-form-label text-md-right">{{ __('Template - (.png,.jpg)') }}</label>
                        
                                <div class="col-md-6">
                                    <input id="template" type="file" class="form-control btn" name="template" value="{{  old('template') }}" required autofocus>
                                </div>

                            </div>

                            <div class="form-group row">
                                <a href="https://blog.even3.com.br/crachas-para-eventos-academicos/" class="col-md-12  text-md-center">
                                    Clique aqui para conferir algumas dicas sobre como montar seu template
                                </a>                                
                            </div>
                            
                            <div class="form-group row">
                                <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo(opicional) - (.gif)') }}</label>
                        
                                <div class="col-md-6">
                                    <input id="logo" type="file" class="form-control btn" name="logo" value="{{  old('logo') }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Insira as Tags que deseja no crachá aqui, separe vírgula') }}</label>
                        
                                <div class="col-md-6">
                                    <textarea rows="4" cols="20" class="form-control" name="tags" required autofocus></textarea>
                                </div>
                            </div>

                            <div class="card-header headerNTI">{{ __('Opções de Formatação') }}</div>

                            <div class="form-group row">
                                <label for="tamanho" class="col-md-4 col-form-label text-md-right">{{ __('Tamanho') }}</label>
    
                                <div class="col-md-4">
                                    <input id="tamanho" type="number" class="form-control col-md-4" name="tamanho" value="{{  old('tamanho') }}" required autofocus>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="negrito" value="1">
                                    <label class="form-check-label" for="negrito">Negrito</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="itaico" value="1">
                                    <label class="form-check-label" for="itaico">Itálico</label>
                                </div>
                            </div>

                            <div class="card-header headerNTI">{{ __('Dados - Insira a tabela aqui') }}</div>

                            <div class="form-group row">
                        
                                <div class="col-md-12">
                                    <textarea rows="10" cols="20" class="form-control" name="tabela" required autofocus></textarea>
                                </div>
                            </div>
                            
                        </div>
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Baixar Crachás') }}
                                </button>
                            </div>
                        </div>
                    
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

