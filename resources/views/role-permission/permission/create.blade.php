@extends('layout.user-layout')
@section('title', 'SIGOF | AJOUTER PERMISSIONS')
@section('space-work')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @if ($message = Session::get('status'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                        role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                            role="alert">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 pt-1">
                                <span class="d-flex mt-2 align-items-baseline"><a href="{{ route('permissions.index') }}"
                                        class="btn btn-success btn-sm" title="retour"><i
                                            class="bi bi-arrow-counterclockwise"></i></a>&nbsp;
                                    <p> | Liste des permissions</p>
                                </span>
                            </div>
                        </div>
                        <h5 class="card-title">Création permission</h5>
                        <!-- Permission -->
                        <form method="post" action="{{ url('permissions') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <table class="table table-bordered" id="dynamicAddRemove">
                                <tr>
                                    <th>Permissions<span class="text-danger mx-1">*</span></th>
                                    <th width="5%">Action</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="permissions[0][name]"
                                            placeholder="ajouter une permission" class="form-control form-control-sm"
                                            autofocus />

                                        @error('permissions.0.name')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </td>
                                    <td><button type="button" name="add" id="add-btn" class="btn btn-success btn-sm"
                                            title="Ajouter une ligne">Ajouter</button>
                                    </td>
                                </tr>
                            </table>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-left mt-2">
                                <button type="submit" class="btn btn-outline-info btn-sm"><i
                                        class="far fa-save"></i>&nbsp;Sauvegarder</button>
                            </div>

                        </form>
                        <!-- End Permission -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        var i = 0;
        $("#add-btn").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><input type="text" name="permissions[' + i +
                '][name]" placeholder="ajouter une autre permission" class="form-control form-control-sm" /></td><td><button type="button" class="btn btn-danger btn-sm remove-tr">Supprimer</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
@endpush
