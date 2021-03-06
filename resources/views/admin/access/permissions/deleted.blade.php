@extends('layouts.app')
@push('title') Deleted Permissions List @endpush
@section('content')
<div class="card-box">
   <div class="card-block">
      <div class="row">
         <div class="col-md-5">
            <h4 class="card-title">Permissions</h4>
         </div>
         <div class="col-md-7 page-action text-right">
            <a href="{{ route('admin.access.permissions.create') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Create Permission</a>
         </div>
      </div>
      <div class="table-responsive">
         <table class="table">
            <thead>
               <tr>
                  <td>#</td>
                 <td>Name</td>
                 <td>Description</td>
                 <td>Created At</td> 
                 <td class="text-center">Actions</td> 
               </tr>
            </thead>
            <tbody>

            @foreach($permissionList as $permissionKey => $permissionValue)
          <tr>
             <td>@include('comman.serialnumber', ['serNo' => $permissionList])</td>
             <td>{{ $permissionValue->name }}</td>
             <td>{{ $permissionValue->description }}</td>
             <td>{{ $permissionValue->created_at }}</td>
             <td class="text-center">
                 @include('comman.buttons.actionbutton.softgateaction', [
                        'modelObject' => $permissionValue,
                        'buttonsList' => [
                           'FORCE_DELETE' =>   ['permission' => 'permission_force_delete','route' => 'admin.access.permissions.forcedelete'],
                           'RESTORE' => ['permission' => 'permission_restore','route' => 'admin.access.permissions.restore'],
                           ]])
             </td>
          </tr>
          @endforeach

              
               
            </tbody>
         </table>
      </div>
      <div class="text-center">
         {{ $permissionList->links() }}
      </div>
   </div>
</div>
@endsection

