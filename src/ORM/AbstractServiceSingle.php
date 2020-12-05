<?php

namespace Fykosak\Utils\ORM;

use Fykosak\Utils\ORM\Exceptions\ModelException;
use InvalidArgumentException;
use Nette\Database\Connection;
use Nette\Database\Context;
use Nette\Database\IConventions;
use Nette\Database\Table\Selection;
use Nette\InvalidStateException;
use PDOException;

/**
 * Service class to high-level manipulation with ORM objects.
 * Use singleton descendant implementations.
 * @author Michal Koutný <xm.koutny@gmail.com>
 * @author Michal Červeňak <miso@fykos.cz>
 */
abstract class AbstractServiceSingle extends Selection {

    private string $modelClassName;
    private string $tableName;

    public function __construct(Context $connection, IConventions $conventions, string $tableName, string $modelClassName) {
        $this->tableName = $tableName;
        $this->modelClassName = $modelClassName;
        parent::__construct($connection, $conventions, $tableName);
    }

    /**
     * @param array $data
     * @return AbstractModel
     * @throws ModelException
     */
    public function createNewModel(array $data): AbstractModel {
        $modelClassName = $this->getModelClassName();
        $data = $this->filterData($data);
        try {
            $result = $this->getTable()->insert($data);
            if ($result !== false) {
                return ($modelClassName)::createFromActiveRow($result);
            }
        } catch (PDOException $exception) {
            throw new ModelException('Error when storing model.', null, $exception);
        }
        $code = $this->getConnection()->getPdo()->errorCode();
        throw new ModelException("$code: Error when storing a model.");
    }

    /**
     * Syntactic sugar.
     *
     * @param mixed $key
     * @return AbstractModel|null
     */
    public function findByPrimary($key): ?AbstractModel {
        /** @var AbstractModel|null $result */
        $result = $this->getTable()->get($key);
        return $result;
    }

    /**
     * @param AbstractModel $model
     * @return AbstractModel|null
     */
    public function refresh(AbstractModel $model): AbstractModel {
        return $this->findByPrimary($model->getPrimary(true));
    }

    /**
     * @param AbstractModel $model
     * @param array $data
     * @return bool
     */
    public function updateModel2(AbstractModel $model, array $data): bool {
        try {
            $this->checkType($model);
            $data = $this->filterData($data);
            return $model->update($data);
        } catch (PDOException $exception) {
            throw new ModelException('Error when storing model.', null, $exception);
        }
    }

    /**
     * Use this method to delete a model!
     * (Name chosen not to collide with parent.)
     *
     * @param AbstractModel $model
     * @throws InvalidArgumentException
     * @throws InvalidStateException
     */
    public function dispose(AbstractModel $model): void {
        $this->checkType($model);
        if (!$model->delete() === false) {
            $code = $this->context->getConnection()->getPdo()->errorCode();
            throw new ModelException("$code: Error when deleting a model.");
        }
    }

    public function getTable(): TypedTableSelection {
        return new TypedTableSelection($this->getModelClassName(), $this->getTableName(), $this->context, $this->conventions);
    }

    public function getConnection(): Connection {
        return $this->context->getConnection();
    }

    public function getContext(): Context {
        return $this->context;
    }

    public function getConventions(): IConventions {
        return $this->conventions;
    }

    /**
     * @param AbstractModel $model
     * @throws InvalidArgumentException
     */
    private function checkType(AbstractModel $model): void {
        $modelClassName = $this->getModelClassName();
        if (!$model instanceof $modelClassName) {
            throw new InvalidArgumentException('Service for class ' . $this->getModelClassName() . ' cannot store ' . get_class($model));
        }
    }

    /**
     * Omits array elements whose keys aren't columns in the table.
     *
     * @param array $data
     * @return array
     */
    protected function filterData(array $data): array {
        $result = [];
        foreach ($this->getColumnMetadata() as $column) {
            $name = $column['name'];
            if (array_key_exists($name, $data)) {
                $result[$name] = $data[$name];
            }
        }
        return $result;
    }

    private array $columns;

    private function getColumnMetadata(): array {
        if (!isset($this->columns)) {
            $this->columns = $this->context->getConnection()->getSupplementalDriver()->getColumns($this->getTableName());
        }
        return $this->columns;
    }

    final protected function getTableName(): string {
        return $this->tableName;
    }

    /** @return string|AbstractModel */
    final public function getModelClassName(): string {
        return $this->modelClassName;
    }
}
