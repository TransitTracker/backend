<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Transit Tracker</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        heading: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '#FDF2F8',
                            100: '#FCE7F3',
                            200: '#FBCFE8',
                            300: '#F9A8D4',
                            400: '#F472B6',
                            500: '#EC4899',
                            600: '#DB2777',
                            700: '#BE185D',
                            800: '#9D174D',
                            900: '#831843',
                        },
                    }
                }
            }
        }
    </script>
</head>

<body class="antialiased text-gray-900 bg-gray-100 dark:bg-neutral-900 dark:text-gray-100">

    <header class="bg-white dark:bg-neutral-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white font-heading">
                Transit Tracker Forms
            </h1>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-12 bg-white dark:bg-neutral-800">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} Transit Tracker. All rights reserved.
        </div>
    </footer>

</body>

</html>
