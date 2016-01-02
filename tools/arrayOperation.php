<?php

function getRandomNbElements($listElements, $nbElements) {
   $listToReturn;
    if($listElements !== null && $nbElements > 0 && $nbElements <= count($listElements)) {
      $i = 0;
      while ($i < count($listElements) && $i < $nbElements) {
        $indexElement = rand(0, count($listElements)-1);

        $listToReturn[] = $listElements[$i];
        array_splice($listElements, $indexElement, 1);

        $i++;
      }

      return $listToReturn;
  } else if($nbElements > count($listElements)){
    return $listElements;
  }
  return null;
}
