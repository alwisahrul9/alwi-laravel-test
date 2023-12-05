@extends('layout.main')

@section('content')

  @include('index.addData')
  @include('index.editData')
  @include('index.deleteData')

  <h1 class="text-center font-bold text-4xl mb-5">Company List</h1>

  <div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-black-500 dark:text-black-400" id="myTable">
        <thead class="text-xs text-white uppercase bg-black-50 dark:bg-gray-700">
          <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Address</th>
            <th scope="col" class="px-6 py-3">Email</th>
            <th scope="col" class="px-6 py-3">Actions</th>
          </tr>
        </thead>
    </table>
  </div>
  @include('index.script')
  
@endsection