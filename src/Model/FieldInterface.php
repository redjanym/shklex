<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Model;


interface FieldInterface
{
    const TYPE_STRING = 1;
    const TYPE_TEXT = 2;
    const TYPE_NUMBER = 3;
    const TYPE_CHOICE = 4;
}