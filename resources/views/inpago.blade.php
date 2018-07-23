@extends('master')

@section('contenido')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <center><h1>Prueba de pagos</h1></center>
  </div>
</div>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-4"><p><a class="btn btn-danger" href="{{ url('/') }}" role="button">Cancelar</a></p></div>
    <div class="col-md-4">
      <div class="row">
        <div class="col-lg-12">
          <div class="col-lg-12">
            @if(!isset($l_bank))
            <div class="alert alert-danger" role="alert"><center>No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde.</center></div>
            @else
            <div class="input-group{{ $errors->has('s_banco') ? ' has-error' : '' }}">
              <span class="input-group-addon">
                Banco
              </span>
              <select  class="form-control"name="s_banco" id="s_banco">
                <option selected value="">Seleccione...</option>
                @foreach ($l_bank as $banco)
                <option value="{{ $banco['bankCode'] }}">{{ $banco['bankName'] }}</option>
                @endforeach
              </select>
              @if ($errors->has('s_banco'))
              <span class="help-block">
                <strong>{{ $errors->first('s_banco') }}</strong>
              </span>
              @endif
            </div>
            @endif

          </div>
          <hr>
          <div class="input-group{{ $errors->has('t_persona') ? ' has-error' : '' }}">
            <span class="input-group-addon">
              Tipo de cuenta
            </span>
            <select class="form-control" name="t_persona" id="t_persona">
              <option selected value="">Seleccione...</option>
              <option value="0">Persona</option>
              <option value="1">Empresas</option>
            </select>

            @if ($errors->has('t_persona'))
            <span class="help-block">
              <strong>{{ $errors->first('t_persona') }}</strong>
            </span>
            @endif
          </div>
        </div>
        <hr>
        
        <hr>

        <div class="col-lg-12">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

              @if ($errors->has('name'))
              <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
          </div>

        </div>

      </div>
    </div>
    <div class="col-md-4"></div>
  </div>

  <hr>
</div> <!-- /container -->
@endsection