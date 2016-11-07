@extends('layouts.default')
@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit Set</h5>
                        <div class="ibox-tools">
                            <a href="/sets/edit/{{ $set->id }}" class="btn btn-default btn-xs">Edit Set</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            {{csrf_field()}}

                            <div class="row" >
                                 <div class="col-lg-3"><label > Name</label></div>
                                <div class="col-lg-3">
                                    <p class="form-control-static">{{ $set->name}}</p>
                                </div>
                        
                                <div class="col-lg-3"><label >Active</label></div>
                                <div class="col-lg-3">
                                    <p class="form-control-static">{{ $set->active == 1 ? "Yes":"No" }}</p>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-lg-3"><label >Created_at</label></div>
                                <div class="col-lg-3">
                                    <p class="form-control-static">{{ $set->created_at }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3"><label >QR Code</label></div>
                                <div class="col-lg-3">
                                  <a href="#" class="btn btn-success btn-xs" id="btn-show-qr">Show</a>
                                </div> 
                                <div class="col-lg-3">
                                    <p class="form-control-static qrcode"><div id="qrcode" style="display: none;"></div></p>
                                </div>
                            </div>
                            <hr/>
                            <h3>Camera</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-default btn-sm pull-right m-y-10 btn-create-camera">Add Camera</button>
                                </div>
                            </div>
                            @if (count($set->cameras))
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Ip Address</th>
                                            <th>Created At</th>
                                            <th>Active</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_body">
                                        @foreach ($set->cameras as $camera)
                                            <tr data-id="{{ $camera->id }}" data-name="{{ $camera->name }} " data-ip_address="{{ $camera->ip_address }}" data-created_at="{{ $camera->created_at }}" data-active="{{ $camera->active }}" >
                                                <td>{{ $camera->name }}</td>
                                                <td>{{ $camera->ip_address }}</td>
                                                <td>{{ $camera->created_at }}</td>
                                                <td>{{ $camera->active ? "Yes":"No"  }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#" class="btn-edit-camera">Edit</a></li>
                                                            <li><a href="#" class="btn-delete-camera">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="/js/modalform.js"></script>
    <script  src="/js/jquery.qrcode.js"></script>
    <script  src="/js/qrcode.js"></script>
    <script>
        $('#btn-show-qr').on('click', function() {
            $('#qrcode').toggle();
            $("#btn-show-qr").html($("#btn-show-qr").html() == 'Show' ? 'Hide' : 'Show');
        });

        var camera_modal_html = ''+
            '<form action="/sets/add-camera" method="post" class="form-horizontal">'+
                '<div class="form-group">'+
                    '<label class="col-md-3 control-label">Camera Name</label>'+
                    '<div class="col-md-9"><input type="text" name="name" class="form-control"></div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-md-3 control-label">Ip Address</label>'+
                    '<div class="col-md-9"><input type="text" name="ip_address" class="form-control"></div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-md-3 control-label">Active</label>'+
                    '<div class="col-md-9"><label class="radio-inline">'+
                    '<input type="checkbox" name="active" value="1" ></label></div>'+
                '</div>'+
                '<input type="hidden" name="set_id" value="{{ $set->id }}">'+
                '{{ csrf_field() }}'+
            '</form>';

        $('.btn-create-camera').on('click', function() {
            modalform.dialog({
                bootbox: {
                    title: 'Create New Camera',
                    message: camera_modal_html,
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-default'
                        },
                        submit: {
                            label: 'Create Camera',
                            className: 'btn-primary'
                        }
                    }
                },
                after_init: function() {
                    $('input[name="active"]').attr("checked","checked");
                }   
            });
        });

        $('.btn-edit-camera').on('click', function(event) {
            event.preventDefault();

            var tr = $(this).closest('tr');

            modalform.dialog({
                bootbox: {
                    title: 'Edit Camera',
                    message: camera_modal_html,
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-default',
                        },
                        submit: {
                            label: 'Save Changes',
                            className: 'btn-primary'
                        }
                    }
                },
                after_init: function() {
                    $('.modal input[name="name"]').val(tr.data('name'));
                    $('.modal input[name="ip_address"]').val(tr.data('ip_address'));
                    if(tr.data('active') == 1){
                        $('input[name="active"]').attr("checked","checked");
                    }
                    $('.modal  form').attr('action', '/sets/edit-camera/' + tr.data('id'));
                }
            });
        });

        $('.btn-delete-camera').on('click', function(event) {
            event.preventDefault();
            var camera_id = $(this).closest('tr').data('id');

            modalform.dialog({
                bootbox : {
                    title: 'Delete Camera',
                    message: ''+
                        '<form action="/sets/delete-camera/' + camera_id + '" method="post" class="form-horizontal">'+
                            '<p>Are you sure you want to delete this  entry?</p>'+
                            '{{ csrf_field() }}'+
                        '</form>',
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-default'
                        },
                        submit: {
                            label: 'Delete Camera',
                            className: 'btn-danger'
                        }
                    }
                }
            });
        });
        $('#qrcode').qrcode('{{$qrstring}}');
    </script>
@endsection
