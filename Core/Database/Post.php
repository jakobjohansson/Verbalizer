<?php

namespace kiwi\Database;

class Post extends Model
{
    /**
     * Get all posts in descending order.
     *
     * @return array
     */
    public static function all()
    {
        $builder = self::builder();

        return $builder->select('*')
            ->from('posts')
            ->expect(self::class)
            ->get();
    }

    /**
     * Save a post to the database.
     *
     * @return PDOStatement
     */
    public function save()
    {
        $this->runValidation();
        $builder = self::builder();

        $builder->insert($this)
            ->to('posts')
            ->run();
    }
}
