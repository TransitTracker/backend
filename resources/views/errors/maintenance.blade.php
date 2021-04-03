<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transit Tracker | Maintenance mode</title>
</head>
<body>
    <script>
        const vuex = localStorage.getItem('vuex')
        const redirect = (vuex) => {
            const enUrl = 'https://status.transittracker.ca/'
            const frUrl = 'https://ohdear.app/status-page/transittracker-fr'
            
            if (!vuex) return window.location.replace(enUrl)
    
            const settings = JSON.parse(vuex).settings
            console.log(settings)
    
            if (settings.language === 'fr') return window.location.replace(frUrl)
            return window.location.replace(enUrl)            
        }

        redirect(vuex)
    </script>
</body>
</html>