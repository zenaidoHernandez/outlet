@extends('principal.layout')
@section('title', 'CAPTURA DE DATOS')
@section('content')
    <script
            src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>
    <section class="content">
        <div class="row">
        <form role="form" action="{{route('tipo_cambio.store')}}" method="post">
            @csrf
                <!-- left column -->
            <div class="col-md-5">
            <!-- general form elements -->
            <div class="box box-primary">

                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="col-sm-4">Tipo de cambio</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                            <input type="number" class="form-control" id="tipocambio" name="t_cambio" placeholder="Tipo de cambio actual" required="required" value="18.90">
                            </div>
                        </div>
                    </div><br><br>



                    <!-- /.box-body -->

                    <div class="box-footer">
                    <div>
                        <button>Guardar</button>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
        </div>
    </section>
@endsection