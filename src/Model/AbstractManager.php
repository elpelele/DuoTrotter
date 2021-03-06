<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */
namespace App\Model;

use App\Model\Connection;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    /**
     * @var \PDO
     */
    protected $pdo; //variable de connexion

    /**
     * @var string
     */
    protected $table;
    /**
     * @var string
     */
    protected $className;


    /**
     * Initializes Manager Abstract class.
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
        $this->pdo = (new Connection())->getPdoConnection();
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }

    /** Get all row from database by Alphabetical Order */
    public function selectAllbyAlphabeticalOrder(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table . ' ORDER BY name')->fetchAll();
    }

    /** Get all row from database by order */
    public function selectAllByDate(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table . ' ORDER BY date DESC')->fetchAll();
    }

    /** Get all articles from database order by date */
    public function selectAllLimit(int $nbr): array
    {
        return $this->pdo->query("SELECT * FROM $this->table ORDER by date DESC LIMIT $nbr")->fetchAll();
    }

    /** Get all countries from database by ID */
    public function selectAllByCountry($id): array
    {
        return $this->pdo->query("SELECT * FROM $this->table WHERE countries_id = $id ")->fetchAll();
    }

    /** Get all categories from database by ID */
    public function selectAllByCategory($id): array
    {
        return $this->pdo->query("SELECT * FROM $this->table WHERE categories_id = $id ")->fetchAll();
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneById(int $id): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /** Get all articles from database by ID */
    public function selectAllByArticle(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE articles_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
