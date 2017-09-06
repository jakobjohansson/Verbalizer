<?php

namespace kiwi\Database;

use kiwi\Container;
use kiwi\Http\Request;

class Migration
{
    /**
     * The PDO instance.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * The tables to be dropped.
     *
     * @var array
     */
    private $droppable = ['posts'];

    /**
     * Creates a new Migration instance.
     *
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->drop()->migrate();
    }

    /**
     * Return a new instance.
     *
     * @return static
     */
    public static function refresh()
    {
        return new static(Container::resolve('connection'));
    }

    /**
     * Drop all the tables if they exist.
     *
     * @return $this
     */
    private function drop()
    {
        foreach ($this->droppable as $droppable) {
            $query = $this->pdo->query('DROP TABLE IF EXISTS '.$droppable);

            $query->execute();
        }

        return $this;
    }

    /**
     * Refresh the migration.
     *
     * @return void
     */
    private function migrate()
    {
        $query = $this->pdo->query(
            "CREATE TABLE IF NOT EXISTS `posts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) DEFAULT NULL,
                `body` text,
                `public` tinyint(4) DEFAULT '1',
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains all posts on the site.';"
        );

        $query->execute();

        $query = $this->pdo->prepare(
            "INSERT INTO `posts` (`title`, `body`)
                VALUES
                ('Hello World!','Welcome to kiwi! This is the first post');"
        );

        $query->execute();

        $this->pdo = null;

        Request::redirect('/');
    }
}
