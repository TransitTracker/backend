<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transit Tracker Beta</title>
    <style>
        .tt-beta {
            background-color: #eef6fc;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        .tt-beta h1 {
            margin-top: 2rem;
            margin-bottom: 2rem;
            margin-left: 2rem;
            font-size: 1rem;
            font-weight: 500;
        }
        
        .tt-beta .button {
            margin-left: 2rem;
            display: inline-flex;
            height: 2.25rem;
            background-color: #2374ab;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            text-decoration: none;
            align-items: center;
            padding: 0 1rem;
            font-size: .875rem;
            border-radius: 0.25rem;
            transition: background-color 0.25s ease-in-out;
            visibility: hidden;
        }

        .tt-beta .button:hover {
            background-color: #00497b;
        }
    </style>
</head>
<body class="tt-beta">
    <h1>
        @if(App::isLocale('en'))
            Loading....
        @else
            Chargement...
        @endif
    </h1>

    <a href="https://dev.transittracker.ca" id="button" class="button">
        @if(App::isLocale('en'))
            Click here
        @else
            Cliquez ici
        @endif
    </a>

    <script>
        setTimeout(() => {
            document.getElementById('button').style.visibility = 'visible'
        }, 1000)

        const settings = JSON.parse(localStorage.getItem('vuex')).settings

        if (!settings) {
            window.location = 'https://dev.transittracker.ca/'
        } else {
            const url = new URLSearchParams()
    
            url.append('ag', settings.activeAgencies)
            url.append('ar', settings.autoRefresh)
            url.append('dm', settings.darkMode)
            url.append('dp', settings.defaultPath)
            url.append('la', settings.language)
            url.append('re', settings.activeRegion)
    
            // window.location = 'https://dev.transittracker.ca/migrate?' + url.toString()
        }

    </script>
</body>
</html>