@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <form action="{{route('orders.payments.store', $order)}}" method="POST" class="form-horizontal">
                        <div class="panel-body">
                            <div class="alert alert-info text-center"> Estás a punto de pagar
                                <b>{{ $order->formattedAmount() }} COP</b>
                            </div>

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email" class="control-label">Email de la orden: {{$order->email}}</label>
                            </div>

                            <h3 class="page-header">Información del Comprador</h3>

                            {{-- Name--}}
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="firstName">Nombre:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>

                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--Last Name--}}
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="lastName">Apellidos:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--Document Type--}}
                            <div class="form-group{{ $errors->has('document_type') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="documentType">Tipo de Documento:</label>

                                <div class="col-md-6">
                                    <select name="document_type" id="documentType" class="form-control" required>
                                        <option value="CC">Cédula de ciudadanía colombiana</option>
                                        <option value="CE">Cédula de extranjería</option>
                                        <option value="TI">Tarjeta de identidad</option>
                                        <option value="PPN">Pasaporte</option>
                                        <option value="NIT">Numero de Identificación Tributaria</option>
                                        <option value="SSN">Social Security Number</option>
                                    </select>

                                    @if ($errors->has('document_type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('document_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--Last Name--}}
                            <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="document">Documento:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="document" name="document" required>

                                    @if ($errors->has('document'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('document') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        <div class="panel-footer">
                            <div class="clearfix">
                                <button type="submit" class="btn btn-primary pull-right">
                                    Siguiente
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection