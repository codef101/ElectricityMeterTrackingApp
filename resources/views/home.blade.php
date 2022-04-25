@extends('layouts.app')

@section('content')
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Meters Table</title>

        <!-- TailwindCSS -->
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito';
            }
        </style>

        @livewireStyles
</head>
    <div class="container mx-auto">
                        <form action="{{ route('excel-import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control">
                            <br>
                            <button class="btn btn-success">Import User Data</button>

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#studentModal" >Add New Consumer</button>
                        </form>
                        
        <h1 class="text-3xl text-center my-10">Meters Table</h1>
        <livewire:meters-table>
    </div>
            
    @livewireScripts
    
    @section('script')
    <script>
        window.addEventListener('close-modal', event => {

            $('#studentModal').modal('hide');
            $('#updateStudentModal').modal('hide');
            $('#deleteStudentModal').modal('hide');
        })
    </script>
    @stop
@endsection
