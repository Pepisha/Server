<?php

function getRandomNbElements($listElements, $nbElements) {
    if ($listElements === null || $nbElements <= 0) {
      return null;
    }

    if ($nbElements <= count($listElements)) {
      $listToReturn = array();

      $keys = array_rand($listElements, $nbElements);
      foreach ($keys as $key) {
        $listToReturn[$key] = $listElements[$key];
      }

      return $listToReturn;
    } else {
      return $listElements;
    }
}
