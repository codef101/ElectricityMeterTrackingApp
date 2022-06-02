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
                #main{
                    text-align: center;
                    width: 100%;
                    padding: 2%;
                }
                /* Set height of body and the document to 100% to enable "full page tabs" */
                body, html {
                height: 100%;
                margin: 0;
                font-family: Arial;
                }

                /* Style tab links */
                .tablink {
                background-color: #555;
                color: rgb(5, 5, 5);
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                font-size: 17px;
                width: 33.3%;
                }

                .tablink:hover {
                background-color: #777;
                }

                /* Style the tab content (and add height:100% for full page content) */
                .tabcontent {
                color: rgb(0, 0, 0);
                display: none;
                padding: 100px 20px;
                height: 100%;
                text-align: center;
                margin: auto;
                }

                #Home {
                    background-color: rgb(255, 255, 255);
                    text-align: center;
                    width: 60%;
                }
                #News {background-color: rgb(255, 255, 255);}
                #Contact {background-color: rgb(255, 255, 255);}
                #About {background-color: rgb(255, 255, 255);}

            </style>

            @livewireStyles
</head>
    <div >

        <livewire:meters-table>
            <script>
                window.addEventListener('close-modal', event => {

                    $('#studentModal').modal('hide');
                    $('#updateStudentModal').modal('hide');
                    $('#deleteStudentModal').modal('hide');
                })

                function openPage(pageName, elmnt, color) {
                // Hide all elements with class="tabcontent" by default */
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                // Remove the background color of all tablinks/buttons
                tablinks = document.getElementsByClassName("tablink");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].style.backgroundColor = "";
                }

                // Show the specific tab content
                document.getElementById(pageName).style.display = "block";

                // Add the specific color to the button used to open the tab content
                elmnt.style.backgroundColor = color;
                }

                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>
    </div>

    @livewireScripts
@stop
