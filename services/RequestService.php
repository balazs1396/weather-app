<?php

use enums\QueryFilters;

class RequestService
{
    public static $instance;

    public static function getInstance() {
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getValidQueryFields(?string $query): array
    {
        if (!$query) {
            return [];
        }

        $fields = [];
        foreach (explode('&', $query) as $field) {
            $fieldParts = explode('=', $field);

            if (in_array($fieldParts[0], QueryFilters::ALL) && $fieldParts[1] ?? null) {
                $fields[$fieldParts[0]] = $fieldParts[1];
            }
        }

        // do no accept if only one field is filled
        return count($fields) != 2 ? [] : $fields;
    }
}
