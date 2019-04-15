@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img src="{{$product->src()}}" class="img-responsive w-100 h-100" alt="...">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="page-header">{{ \App\Product::description() }}</h3>
                <div class="clearfix">
                    <p class="pull-right"><b>Precio:</b> {{$product->formattedPrice()}} COP (Por Zapato)</p>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('orders.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Correo Electrónico:</label>

                        <div class="col-md-6">
                            <input class="form-control"
                                id="email"
                                value="{{ old('email')}}"
                                type="email"
                                min="1"
                                name="email"
                                required
                                autofocus
                            >

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                        <label for="quantity" class="col-md-4 control-label">Cantidad a comprar:</label>

                        <div class="col-md-6">
                            <input class="form-control"
                                    id="quantity"
                                    value="{{ old('quantity')}}"
                                    type="number"
                                    min="1"
                                    name="quantity"
                                    required
                            >

                            @if ($errors->has('quantity'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>                            

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Realizar Pago
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection