/**
 * created by Nathanael Weber
 * Reads the values of the top bar url
 */

/**
 * Is called when the page is ready to prevent errors
 */
$(document).ready(function() {
	var url = location.search.substring(1);
	var object = $.parseJSON('{"' + decodeURIComponent(url.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}');

	/**
	 * makes the difference between sign in and sign up
	 * and shows the data
	 */
	if (object.password2.toString() == "" && object.gender == undefined) {
		$("#title").text("Erfolgreich angemeldet");
		$("p").text("Sie haben sich erfolgreich mit " + object.username + " angemeldet.");
	} else {
		var sportTypes = object.sportTypes1 == undefined ? "" : object.sportTypes1 + ", ";
		sportTypes += object.sportTypes2 == undefined ? "" : object.sportTypes2 + ", ";
		sportTypes += object.sportTypes3 == undefined ? "" : object.sportTypes3 + ", ";
		sportTypes += object.sportTypes4 == undefined ? "" : object.sportTypes4;

		$("#title").text("Erfolgreich registriert");
		$("p").html("Sie haben sich erfolgreich mit " + object.username + " registriert."
		+ "<br><br><br><h2>Ihre Daten...</h2>" + "<table>" +
			"<tbody><tr><td>" +
			"Username: </td><td>" +
			object.username + "</td>" +
			"</tr><tr>" +
			"<td>Geschlecht: " +
			"<td>" +
			object.gender + "</td></tr>" +
			"<tr><td>" +
			"Sportarten: <td>" +
			sportTypes + "</td></td><tr>" +
			"<td>Wohnort: " +
			"</td><td>" +
			object.location + "</td>" +
			"</td></tr>" +
			"</tr></tbody></table>"
		);
	}
});
