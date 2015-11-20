<?php

function jsonEncode($data) {
    if (is_array($data)) {
        return json_encode($data);
    }
}
