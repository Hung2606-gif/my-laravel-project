@extends('layouts.admin')

@section('content')
<div class="flex justify-center items-center min-h-full">
    <div class="bg-white bg-opacity-90 p-8 rounded-xl shadow-lg text-center space-y-4">
     
        <a href="{{ route('users.index') }}">
            <button class="mt-4 px-4 py-2 bg-blue-500 text-red rounded-lg hover:bg-blue-600 transition duration-300">
                User Profile
            </button>
        </a>
    </div>
</div>
@endsection

