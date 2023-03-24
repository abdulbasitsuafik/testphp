<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<title>Etkinlik Takvimi</title>
	<link rel="shortcut icon" href="img/favicon.ico" />

	<!-- Grid CSS File (only needed for demo page) -->
	<link rel="stylesheet" href="css/paragridma.css">

	<!-- Core CSS File. The CSS code needed to make eventCalendar works -->
	<link rel="stylesheet" href="css/eventCalendar.css">

	<!-- Theme CSS file: it makes eventCalendar nicer -->
	<link rel="stylesheet" href="css/eventCalendar_theme_responsive.css">

	<!--<script src="js/jquery.js" type="text/javascript"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>

</head>
<body id="responsiveDemo">
	<div class="container">
		
		<div class="row">
			<div class="g4 first">
                <h2>Etkinlik Takvimi</h2>
                <p></p>
				<div id="eventCalendarLocaleFile"></div>
				<script>
					$(document).ready(function() {
						$("#eventCalendarLocaleFile").eventCalendar({
							eventsjson: 'json/events.json.php',
							locales: {
								locale: "es",
								monthNames: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
									"Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
								dayNames: [ 'Pazar','Pazartesi','Salı','Çarşamba','Perşembe',
									'Cuma','Cumartesi' ],
								dayNamesShort: [ 'Paz','Pzt','Sal','Çar','Per', 'Cum','Cmt' ],
								txt_noEvents: "Etkinlik Yok",
								txt_SpecificEvents_prev: "",
								txt_SpecificEvents_after: "Etkinlikler:",
								txt_next: "Sonraki",
								txt_prev: "Önceki",
								txt_NextEvents: "Yaklaşan Etkinlikler:",
								txt_GoToEventUrl: "Etkinliğe Git",
								"moment": {
							        "months" : [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
									"Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
							        "monthsShort" : [ "Oca", "Şub", "Mar", "Nis", "May", "Haz",
							                "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara" ],
							        "weekdays" : [ "Domingo","Lunes","Martes","Miércoles",
							                "Jueves","Viernes","Sabado" ],
							        "weekdaysShort" : [ 'Paz','Pzt','Sal','Çar','Per', 'Cum','Cmt' ],
							        "weekdaysMin" : [ "Do","Lu","Ma","Mi","Ju","Vi","Sa" ],
							        "longDateFormat" : {
							            "LT" : "H:mm",
							            "LTS" : "LT:ss",
							            "L" : "DD/MM/YYYY",
							            "LL" : "D [de] MMMM [de] YYYY",
							            "LLL" : "D [de] MMMM [de] YYYY LT",
							            "LLLL" : "dddd, D [de] MMMM [de] YYYY LT"
							        },
							        "week" : {
							            "dow" : 1,
							            "doy" : 4
							        }
							    }
							}
						});
					});
				</script>
			</div>
           
		</div>
	</div>
	
	
</body>

<!-- plugin has dependency of moment.js to show dates -->
<script src="js/moment.js" type="text/javascript"></script>

	<!--  development version 
	<script src="js/jquery.eventCalendar.js" type="text/javascript"></script>
-->
<!--
	minify version
-->
	<script src="js/jquery.eventCalendar.min.js" type="text/javascript"></script>

</html>