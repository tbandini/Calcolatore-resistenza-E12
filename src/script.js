$("#btn").click((e) => {
    e.preventDefault();

    var xhttp = new XMLHttpRequest();

    var Vcc = $("#Vcc").val();
    var I = $("#I").val();
    var Vgamma = $("#Vgamma").val();

    // Stabilisco la connessione
    xhttp.open("POST", "/5ATL/bandi.t.160803/CalcoloResistenza/es.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Controllo che i valori siano inseriti
    if (Vcc == "" || I == "") {
        alert("Inserire tutti i valori");
        return;
    }

    // Controllo che i valori siano positivi
    if (Vcc < 0 || I < 0) {
        alert("I valori non possono essere negativi");
        return;
    }

    // Controllo che la corrente sia compresa tra 5 e 20 mA
    if (I < 0.005 || I > 0.02) {
        alert("Vcc deve essere compreso tra 5 e 20 mA");
        return;
    }

    // Invio il risultato
    xhttp.send("Vcc=" + Vcc + "&I=" + I + "&Vgamma=" + Vgamma);

    // Controllo lo stato della connessione e se positivo stampo il risultato nel index.html
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            // Divido la stringa in due parti
            var responseArray = xhttp.responseText.split("||");
            var colori = responseArray[0].split(",");

            $(".color1").css("background-color", colori[0]);
            $(".color2").css("background-color", colori[1]);
            $(".multiplier").css("background-color", colori[2]);
            $(".tolerance").css("background-color", colori[3]);

            console.log(colori[0]);
            console.log(colori[1]);
            console.log(colori[2]);
            console.log(colori[3]);

            // Stampo il risultato
            $("#numberResult").html(responseArray[1] + "&#8486;");
        }
    };
});
