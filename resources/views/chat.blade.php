<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Styles -->
    <style>
        .list-group {
            overflow-y: scroll;
            height: 200px;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="row" id="app">

            <div class=" offset-3 col-6">
                <li class="list-group-item active">Chat Rooms
                    <span class="badge badge-pill badge-danger">@{{ usersNumbers }}</span>
                </li>
                <div class="badge badge-pill badge-primary">@{{ typing }}</div>
                <ul class="list-group" v-chat-scroll>
                    <message v-for="(value,index) in chat.message" :key="value.index" :color=chat.color[index]
                        :user=chat.user[index] :time=chat.time[index]>@{{ value }}</message>
                    {{-- v-on:keyup='send' --}}
                </ul>
                <input type="text" class="form-control" placeholder="Type Your message here..." name="message"
                    v-model="message" @keyup.enter="send()">
                <center>
                    <div>@{{ message }}</div>
                </center>

            </div>

        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
