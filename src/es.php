<?php
    header('Access-Control-Allow-Origin: *');

    $Vcc = $_POST["Vcc"];
    $I = $_POST["I"];
    $Vgamma = $_POST["Vgamma"];
    
    // Calcolo la resistenza con i dati dati dal javascript
    function calcolo($vcc, $i, $vgamma) {
        $result = ($vcc - $vgamma)/$i;
        return $result;
    }

    $R = calcolo($Vcc, $I, $Vgamma);

    $rPot = 0;
    
    // Calcolo la notazione scientifica della resistenza
    while ($R < 100) {
        $rPot -= 1;
        $R *= 10;
    }

    while ($R > 100) {
        $rPot += 1;
        $R *= 0.1;
    }
    
    $e12= array(10, 12, 15, 18, 22, 27, 33, 39, 47, 56, 68, 82);

    // Trovo la resistenza nella serie e12 più vicina alla resistenza calcolata in precedenza
    for ($i = 0; $i < 12; $i++) {
        if ($R <= $e12[$i]) {
            $R = $e12[$i];
            break;
        }
    }

    // Array contenente i colori della serie e12 in parola senza emoji
    $colori = array(
        "black",
        "brown",
        "red",
        "orange",
        "yellow",
        "green",
        "blue",
        "purple",
        "gray",
        "white",
        "silver"
    );

    function resistenzaFisica($resistenza, $colori, $potenza) {
        $resistenza = strval($resistenza);
        $resistenza = str_split($resistenza);

        if (count($resistenza) > 2 ) {
            $resistenza = array_slice($resistenza, 0, 2);
        }
        $resistenzaFisica = "";

        // Imposto il colore delle cifre significative 
        for ($i = 0; $i < count($resistenza); $i++) {   
            $resistenzaFisica .= $colori[$resistenza[$i]];
            $resistenzaFisica .= ",";
        }

        // Imposto il colore del moltiplicatore
        if ($potenza == -1) {
            // è necessario mettere il colore nero nel caso la notazione scientifica sia -1
            $resistenzaFisica .= $colori[$potenza + 1];
            $resistenzaFisica .= ",";
        }
        else {
            // questo invece è il caso normale
            $resistenzaFisica .= $colori[$potenza];
            $resistenzaFisica .= ",";
        }

        // Imposto la tolleranza che nel caso della serie e12 è sempre del 10%
        $resistenzaFisica .= $colori[10];

        return $resistenzaFisica;
    }
    
    echo resistenzaFisica($R, $colori, $rPot);
    echo " || ";
    echo $R *= pow(10, $rPot);
?>  