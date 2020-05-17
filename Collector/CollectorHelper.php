<?php


namespace Creonit\RestBundle\Collector;


class CollectorHelper
{
    public static function parseDocComment($docComment, &$summary, &$description)
    {
        $docComment = trim(preg_replace('#^[ \t]*/?\*+ */?#m', '', $docComment));
        $docComment = explode('@', $docComment, 2);
        $docComment = preg_split('/[\n\r]+/', $docComment[0], 2);

        $summary = trim($docComment['0']);
        $description = isset($docComment['1']) ? trim($docComment['1']) : '';
    }
}