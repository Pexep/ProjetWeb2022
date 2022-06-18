<?php

function setAlert($type, $alertName, $message){
    $_SESSION[$alertName] = array(
        'type' => $type,
        'message' => $message
    );
}

function showAlert($alertName){
    $colors = array(
        'success' => 'green',
        'error' => 'red',
        'warning' => 'orange',
        'info' => 'blue'
    );
    if(isset($_SESSION[$alertName])){
        $alert = $_SESSION[$alertName];
        ?>
        <div class="w3-panel w3-<?php echo $colors[$alert['type']]?>">
            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-right">X</span> <!-- on crée un bouton qui, au clic, va fermer l'alerte -->
            <h4><?php echo $_SESSION[$alertName]['message']; ?></h4>
        </div>
        <?php
        unset($_SESSION[$alertName]);
    }
    ?>
    <?php
}; 

?>