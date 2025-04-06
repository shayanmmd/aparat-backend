<?php

function generateCodeRandom(){
    return random_int(10, 99) . random_int(10, 99) . random_int(10, 99);
}