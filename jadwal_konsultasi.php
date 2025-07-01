<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Konsultasi</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
    <style>
    body {
        font-family: Arial;
        margin: 20px;
        background: #f4f4f4;
    }

    #calendar {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    a.kembali {
        display: inline-block;
        margin-top: 20px;
        background: #555;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Kalender Konsultasi</h2>
    <div id='calendar'></div>
    <a href="dashboard.php" class="kembali">⬅ Kembali</a>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            events: 'load_jadwal.php' // endpoint PHP untuk ambil data konsultasi
        });
        calendar.render();
    });
    </script>
</body>

</html>