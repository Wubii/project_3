<?php

abstract class Entity 
{
    // force les classes filles a implementer obligatoirement les fonctions persist et remove.
    abstract public function persist();

    abstract public function remove();
}