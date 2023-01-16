<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="api-base-url" content="/api/">

    <!-- Title -->
    <title>Kanban</title>
    <!-- Style sheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<!-- Vue App-->
<div id="app" class="" v-cloak>
    @include('layout.header')
    <flash-message></flash-message>
    <kanban-board v-if="board && boardItem && boardItem.id" :board="boardItem"></kanban-board>
    <add-board></add-board>
    <floating-button @click="exportDB">Export DB</floating-button>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
