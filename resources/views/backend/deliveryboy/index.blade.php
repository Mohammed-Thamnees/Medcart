@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Delivery Boys Lists</h6>
      <a href="{{route('deliveryboys.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Delivery Boy</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($boy)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              
                <th>Name</th>
                <th>Place</th>
                <th>Email</th>
                <th>phone number</th>
                <th>Join Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
          </thead>
          
          <tbody>
           
            @foreach($boy as $boy)   
                <tr>
                    
                    <td>{{$boy->name}}</td>
                    <td>{{$boy->place}}</td>
                    <td>{{$boy->email}}</td>
                    <td>{{$boy->number}}</td>
                    <td>{{(($boy->created_at)? $boy->created_at->diffForHumans() : '')}}</td>
                    <td>
                        @if($boy->status=='active')
                            <span class="badge badge-success">{{$boy->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$boy->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('deliveryboys.edit',$boy->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('deliveryboys.destroy',[$boy->id])}}">
                      @csrf 
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$boy->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                    
                </tr>  
            @endforeach
          </tbody>
        </table>
        
        @else
          <h6 class="text-center">No delivery boys found!!! Please add delivery boys</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4,5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush