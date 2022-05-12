<?php
    
    function formatDate($date){
        return date('d/m/Y h:i:s', strtotime($date));
    }

?>