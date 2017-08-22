<?php

namespace kiwi\Database;

use PDO;

class Meta extends Model
{
    /**
     * Fetch a meta value.
     *
     * @param string $property
     *
     * @return mixed
     */
    public static function get($property)
    {
        return static::builder()->select('site_meta', 'value', ['key', '=', $property]);
    }

    public static function getAll()
    {
        $builder = static::builder();

        $result = $builder->select('*')
            ->from('site_meta')
            ->format(PDO::FETCH_ASSOC)
            ->run();

        $app = [];

        foreach ($result as $row) {
            $app[$row['key']] = $row['value'];
        }

        return $app;
    }
}
