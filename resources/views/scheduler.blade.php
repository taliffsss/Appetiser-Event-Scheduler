<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="format-detection" content="telephone=no">
        
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Preload -->
        <link rel="preload" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" as="style">
        <link rel="preload" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" as="style">
        <link rel="preload" href="//cdn.jsdelivr.net/jquery/latest/jquery.min.js" as="script">
        <link rel="preload" href="//cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" as="script">
        <link rel="preload" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" as="script">
        <link rel="preload" href="//cdn.jsdelivr.net/momentjs/latest/moment.min.js" as="script">
        <link rel="preload" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" as="script">
        <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" as="script">

        <!-- Preconnect -->
        <link rel="preconnect" href="//cdn.jsdelivr.net">

        <!-- DNS Prefetch -->
        <link rel="dns-prefetch" href="//cdn.jsdelivr.net">

        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.css">
        <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div class="container-fluid">
                <div class="card-body">
                    <legend class="border-bottom">
                        Calendar
                    </legend>
                    <div class="row">
                        <div class="col-4 mt-4 pt-3">
                            <form class="event-form" action="{{ route('event.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="event" class="form-label">Event</label>
                                    <input type="text" class="form-control" id="event" aria-describedby="eventHelp" name="event" autocomplete="off">
                                    <span class="text-danger error-text event-error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="daterangepicker" class="form-label">Date Picker</label>
                                    <input type="text" class="form-control bg-white" id="daterangepicker" name="daterangepicker" readonly>
                                    <span class="tex-danger error-text daterangepicker-error"></span>
                                </div>
                                <div class="mb-3 days-section">
                                </div>

                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                        <div class="col mt-2">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="toasts toast-container position-absolute top-0 end-0 p-3">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto toast-title"></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <p class="text-msg"></p>
                </div>
            </div>
        </div>
        <footer>
            <script src="//cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
            <script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js'></script>
            <script src="{{ url('/js/app.js')}}"></script>
        </footer>
    </body>
</html>
